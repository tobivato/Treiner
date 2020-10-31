<?php

declare(strict_types=1);

namespace Treiner\Payment;

use Auth;
use DB;
use Log;
use Exception;
use Gahlawat\Slack\Facade\Slack;
use Segment;
use Treiner\BillingAddress;
use Treiner\Coach;
use Treiner\Player;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Transfer;
use Treiner\Conversation;
use Treiner\JobOffer;
use Treiner\Location;
use Treiner\Notifications\Booking as NotificationsBooking;
use Treiner\Notifications\SessionBooked;
use Treiner\Payment;
use Treiner\Session;
use Treiner\SessionPlayer;

class PaymentHandler
{
    private $token, $billingAddress;

    public function __construct($token, BillingAddress $billingAddress, $playerInfo)
    {
        $this->token = $token;
        $this->billingAddress = $billingAddress;
        $this->playerInfo = $playerInfo;
    }

    /**
     * Creates a Payment object from a job post
     *
     * @param Player $player
     * @param Session $session
     * @return Payment
     */
    public function fromJobPost(Player $player, JobOffer $jobOffer)
    {
        DB::transaction(function() use ($player, $jobOffer) {
            $session = Session::create([
                'coach_id' => $jobOffer->coach->id, 
                'location_id' => $jobOffer->location->id, 
                'fee' => $jobOffer->fee / ($jobOffer->jobPost->length / 60), 
                'length' => $jobOffer->jobPost->length, 
                'starts' => $jobOffer->jobPost->starts, 
                'type' => $jobOffer->jobPost->type, 
                'group_min' => 1, 
                'group_max' => 1, 
                'status' => 'scheduled',
            ]);
            
            $stripeCharge = $this->makeStripePayment($player, $session->coach, $this->token, $jobOffer->fee, 0, $jobOffer->jobPost->idempotency_key);
            
            Conversation::create([
                'from_id' => $player->user->id,
                'to_id' => $session->coach->user->id,
                'subject' => $jobOffer->jobPost->title,
            ]);

            $payment = Payment::create([
                'player_id' => $player->id,
                'amount' => $session->feePerPerson,
                'coach_id' => $session->coach->id,
                'currency' => $session->coach->user->currency,
                'charge_id' => $stripeCharge,
                'billing_address_id' => $this->billingAddress->id,
            ]);

            
            $sessionPlayer = SessionPlayer::create([
                'player_id' => $player->id,
                'session_id' => $session->id, 
                'payment_id' => $payment->id, 
                'review_email_sent' => false,  
                'player_info' => $this->playerInfo,
                'players' => 1,
                ]);
            $jobOffer->jobPost->player->user->notify(new SessionBooked(collect([$sessionPlayer])));
            $this->trackUser($player->user, $sessionPlayer->session->feePerPerson, $sessionPlayer->session->coach->user->currency, "Job offer accepted", $sessionPlayer);
        }, 1);
        $jobPost = $jobOffer->jobPost;
        $jobPost->jobOffers()->delete();
        $jobPost->invitations()->delete();
        $jobPost->delete();
    }

    /**
     * Creates a payment and session/player object from a cart
     *
     * @param Player $player
     * @return void
     */
    public function fromCart(Player $player, $playerCount, $paymentMethod = 'card'): void
    {
        DB::transaction(function() use ($player, $playerCount, $paymentMethod) {
            $sessionPlayers = collect();
            foreach ($player->cartitems as $cartItem) {
                $discount = 0;
                $paymentId = null;

                if ($cartItem->couponPlayer) {
                    $discount = $cartItem->couponPlayer->coupon->calculateDiscount($cartItem->calculatePrice());
                }

                if (!($cartItem->session->supports_cash_payments)) {
                    $paymentMethod = 'card';
                }

                if ($paymentMethod == 'card') {
                    
                    $stripeCharge = $this->makeStripePayment($player, $cartItem->session->coach, $this->token, $cartItem->calculatePrice(), $discount, $cartItem->idempotency_key);

                    $payment = Payment::create([
                        'amount' => $cartItem->session->feePerPerson * $cartItem->players,
                        'currency' => $cartItem->session->coach->user->currency,
                        'charge_id' => $stripeCharge,
                        'player_id' => $player->id,
                        'coach_id' => $cartItem->session->coach->id,
                        'amount' => $cartItem->session->feePerPerson * $cartItem->players,
                        'currency' => $cartItem->session->coach->user->currency,
                        'billing_address_id' => $this->billingAddress->id,
                    ]);

                    $paymentId = $payment->id;
                }

                $sessionPlayer = SessionPlayer::create([
                    'player_id' => $player->id,
                    'session_id' => $cartItem->session->id,
                    'payment_id' => $paymentId,
                    'player_info' => $this->playerInfo,
                    'players' => $playerCount,
                ]);

                $this->trackUser($player->user, $sessionPlayer->session->feePerPerson, $sessionPlayer->session->coach->user->currency, "Session booked from " . $cartItem->session->coach->user->name, $sessionPlayer);

                $cartItem->delete();

                $sessionPlayers->add($sessionPlayer);
                $sessionPlayer->session->coach->user->notify(new NotificationsBooking($sessionPlayer->player, $sessionPlayer->session));

                Conversation::create([
                    'from_id' => $player->user->id,
                    'to_id' => $cartItem->session->coach->user->id,
                    'subject' => __('coaches.' . $cartItem->session->type),
                ]);
            }

            $player->user->notify(new SessionBooked($sessionPlayers));
        }, 1);
    }

    /**
     * Creates the Stripe charge, catches possible errors
     */
    private function makeStripePayment(Player $player, Coach $coach, string $chargeToken, int $sum, int $discount, string $idempotency_key): string
    {
        $charge_id = null;
        
        if (($sum - $discount) < 50) {
            $charge_id = $this->makeTransfer($coach->stripe_token, $sum, $coach->user->currency);
        }

        else {
            $sum = $sum - $discount;
            if ($discount != 0) {
                $this->makeTransfer($coach->stripe_token, $discount, $coach->user->currency);
            }
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $charge = Charge::create([
                    'amount' => $sum,
                    'currency' => $coach->user->currency,
                    'description' => 'Treiner coach #' . $coach->id,
                    'source' => $chargeToken,
                    'application_fee_amount' => $coach->treiner_fee == 0 ? 0 : intval($sum / $coach->treiner_fee),
                    'transfer_data' => [
                        'destination' => $coach->stripe_token,
                    ],                
                    'metadata' => [
                        'coach_id' => $coach->id,
                        'player_id' => $player->id,
                    ],
                ], ['idempotency_key' => $idempotency_key]);

                $charge_id = $charge->id;
            } catch (\Stripe\Exception\CardException $e) {
                Log::notice('Stripe error: card declined');
                abort(500, 'Sorry, your card was declined. Please try again.');
            } catch (\Stripe\Exception\RateLimitException $e) {
                Log::error('Stripe API error: Rate limit exceeded');
                abort(500, 'The rate limit has been exceeded, please try again later.');
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                Log::error('Stripe API error: Invalid parameters ' . $e);
                abort(500, 'Invalid parameters passed. Please try again later.');
            } catch (\Stripe\Exception\AuthenticationException $e) {
                Log::error('Stripe API error: Authentication failed ' . $e);
                abort(500, 'Billing authentication has failed. Please try again.');
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                Log::error('Stripe API error: Network connection from server to Stripe failed');
                abort(500, 'Something went wrong on our end. Please try again later.');
            } catch (\Stripe\Exception\ApiErrorException $e) {
                Log::emergency('Stripe API error exception: ' . $e);
                abort(500, 'Something went wrong on our end. Please contact Treiner support.');
            } catch (Exception $e) {
                Log::error('Error processing payment: ' . $e);
                abort(500, 'Something went wrong on our end. Please try again later.');
            }
        }
        return $charge_id;
    }

    private function makeTransfer($to, $amount, $currency)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return Transfer::create([
            'amount' => $amount,
            'currency' => $currency,
            'destination' => $to
        ])->id;
    }

    private function trackUser(\Treiner\User $user, int $fee, string $currency, string $eventTitle, SessionPlayer $sessionPlayer)
    {
        if (config('app.env') != 'production') {
            return;
        }

        try {
            $session = $sessionPlayer->session;

            Slack::send($eventTitle . ' by ' . $user->name . '. ' . money($fee, $currency) . ' ' . $currency);

            Segment::init(config('services.segment_write_key'));

            Segment::track([
                'userId' => $user->id,
                'event' => 'Order Completed',
                'properties' => [ 
                    'order_id' => $sessionPlayer->payment->id,
                    'total' => $fee / 100,
                    'currency' => $currency,
                    'products' => [
                        [
                            'product_id' => $sessionPlayer->session->id,
                            'name' => __('coaches.' . $session->type) . ' in ' . $session->location->locality,
                            'price' => $fee / 100,
                            'quantity' => $sessionPlayer->players,
                            'category' => 'Sessions',
                            'url' => route('book.store.url', $session),
                        ],
                    ]
                ]
            ]);

            Segment::flush();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}

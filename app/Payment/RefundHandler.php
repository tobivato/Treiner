<?php

declare(strict_types=1);

namespace Treiner\Payment;

use DB;
use Stripe\Refund;
use Stripe\Stripe;
use Treiner\Coach;
use Treiner\User;
use Treiner\Notifications\PlayerWithdraw;
use Treiner\Notifications\SessionCancelled;
use Treiner\Notifications\SessionWithdraw;
use Treiner\Player;
use Treiner\SessionPlayer;

/**
 * Used for creating Stripe refund objects, returning money to bank account and deleting session/player models
 */
class RefundHandler
{
    protected $session;
    /**
     * Takes a session-player model, refunds it, notifies the player and coach and deletes it
     *
     * @param SessionPlayer $sessionPlayer The SessionPlayer model to reverse the creation of
     * @param User          $cancelledBy   The person who is cancelling this session
     */
    public function __construct(SessionPlayer $sessionPlayer, User $cancelledBy)
    {
        DB::transaction(function() use ($sessionPlayer, $cancelledBy) {
            $this->session = $sessionPlayer->session;
            
            if ($sessionPlayer->payment) {
                if ('completed' === $sessionPlayer->status) {
                    $this->refundCard($sessionPlayer->payment->charge_id, false);
                } else {
                    $this->refundCard($sessionPlayer->payment->charge_id, true);
                }
            }

            $sessionPlayer->delete();
        });
    }

    /**
     * Refunds the charge on the card
     */
    private function refundCard(string $charge, bool $refundTotal): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        Refund::create([
            'charge' => $charge,
            'reverse_transfer' => true,
            'refund_application_fee' => $refundTotal,
        ]);
    }

    public function notifyCancellation(Player $player): void
    {
        $player->user->notify(new SessionCancelled($this->session->coach->user->name, $player->user->name, $this->session));
    }

    public function notifyWithdrawal(Player $player, Coach $coach): void
    {
        $player->user->notify(new SessionWithdraw($this->session));
        $coach->user->notify(new PlayerWithdraw($coach->user->name, $this->session->type, $this->session->location->address, $this->session->starts));
    }
}

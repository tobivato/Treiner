<?php

declare(strict_types=1);

namespace Treiner\Payment;

use \Carbon\Carbon;
use Exception;
use Hash;
use Log;
use Propaganistas\LaravelPhone\PhoneNumber;
use Stripe;
use Stripe\OAuth;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Treiner\Coach;

/**
 * Used for creating the payment accounts for each coach.
 */
class PaymentAccountHandler
{
    /**
     * Connects the Stripe API to the user's account
     *
     * @return Redirect
     */
    public static function connectStripeApi(Coach $coach, string $authCode): RedirectResponse
    {
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $response = OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => $authCode,
        ]);

        try {
            $coach->stripe_token = $response->stripe_user_id;
            $coach->user->phone_verified_at = Carbon::now();
            $coach->save();
            $coach->user->save();
            Stripe\Account::update(
                $response->stripe_user_id,
                [
                    'settings' => [
                        'payouts' => [
                            'schedule' => [
                                'interval' => 'weekly',
                                'weekly_anchor' => 'monday',
                            ],
                        ],
                    ],
                    'metadata' => [
                        'coach_id' => $coach->id,
                    ],
                ]
            );
        } catch (Exception $e) {
            Log::info($e);
            return redirect('home')->with('failure', 'There was an issue setting up your Stripe account.');
        }

        return redirect('home')->with('success', 'Your payment settings have been successfully set!');
    }

    /**
     * Creates the link for a coach to set up their Stripe account
     */
    public static function generateStripeAuthLink(Coach $coach): string
    {
        $client_id = config('services.stripe.client_id');
        $state = Hash::make($coach->id);
        $business_type = $coach->is_company ? 'company' : 'individual';
        $phone = PhoneNumber::make($coach->user->phone);
        $countryCode = mb_strtolower($phone->getCountry());
        $shortPhone = $phone->formatNational();

        $attributes = [
            '{redirect_url}' => route('coaches.authorize'),
            '{client_id}' => $client_id,
            '{state}' => $state,
            '{business_type}' => $business_type,
            '{coach_email}' => $coach->user->email,
            '{dob_day}' => $coach->user->dob->day,
            '{dob_month}' => $coach->user->dob->month,
            '{dob_year}' => $coach->user->dob->year,
            '{coach_url}' => route('coaches.show', $coach->id),
            '{phone_number}' => $shortPhone,
            '{country}' => $countryCode,
            '{first_name}' => $coach->user->first_name,
            '{last_name}' => $coach->user->last_name,
        ];

        $connectString = 'https://connect.stripe.com/express/oauth/authorize?redirect_uri={redirect_url}&client_id={client_id}&state={state}&stripe_user[business_type]={business_type}&stripe_user[email]={coach_email}&stripe_user[url]={coach_url}&stripe_user[first_name]={first_name}&stripe_user[last_name]={last_name}&stripe_user[country]={country}&stripe_user[phone_number]={phone_number}&stripe_user[dob_day]={dob_day}&stripe_user[dob_month]={dob_month}&stripe_user[dob_year]={dob_year}';

        return strtr($connectString, $attributes);
    }
}

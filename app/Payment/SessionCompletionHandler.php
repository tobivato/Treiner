<?php

declare(strict_types=1);

namespace Treiner\Payment;

use Auth;
use Carbon\Carbon as Carbon;
use DB;
use Exception;
use Log;
use Stripe\Payout;
use Stripe\Stripe;
use Treiner\Session;

/**
 * This class is used to set a session as complete and pay out to the coach
 */
class SessionCompletionHandler
{
    /**
     * Creates a new SessionCompletionHandler
     */
    public function __construct(Session $session)
    {
        DB::transaction(function() use ($session) {
            if (!(Auth::user()->can('payout', $session))) {
                throw new Exception('Error: session has not yet taken place');
            }

            $amount = intval($session->totalFee - ($session->totalFee * ($session->coach->treiner_fee / 100)));
            $currency = $session->coach->user->currency;
            $account = $session->coach->stripe_token;
            $session->status = 'completed';
            foreach ($session->camps as $camp) {
                $camp->delete();
            }
            $session->save();
        });
    }
}

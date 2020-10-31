<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Carbon\Carbon;
use Treiner\Coach;
use Treiner\NewsletterSubscription;
use Treiner\Notifications\FinishAccount;
use Treiner\Notifications\UpdateSessions;

class CoachSessionReminder
{
    public static function create()
    {
        $coaches = Coach::all();
    
        foreach ($coaches as $coach) {
            if (!(NewsletterSubscription::find($coach->user->email))) {
                continue;
            }
    
            if (count($coach->sessions) == 0) {
                if ($coach->created_at > Carbon::now()->subDays(8)) {
                    $coach->user->notify(new FinishAccount());
                }
            }
            else {
                $session = $coach->sessions->sortByDesc('starts')->first();
                
                if ($session->starts > Carbon::now()->subDays(8)) {
                    $coach->user->notify(new UpdateSessions());
                }
            }
        }
    }
}

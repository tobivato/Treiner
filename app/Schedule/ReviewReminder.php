<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Illuminate\Console\Scheduling\Schedule;
use Treiner\Session;
use Treiner\Notifications\ReviewReminder as ReviewReminderNotification;

class ReviewReminder
{
    public static function create()
    {
            $sessions = Session::all();
            foreach ($sessions as $session) {
                foreach ($session->sessionPlayers as $sessionplayer) {
                    if (!($sessionplayer->review_email_sent)) {
                        $sessionplayer->player->user->notify(new ReviewReminderNotification(route('sessions.index'), $sessionplayer->player->user->first_name, $session->coach->user->name));
                        
                        $sessionplayer->review_email_sent = true;
                        $sessionplayer->save();
                    }
                }
            }
    }
}

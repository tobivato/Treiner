<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Carbon\Carbon;
use Treiner\Session;
use Treiner\Notifications\PlayerSessionReminderNotification;

class PlayerSessionReminder
{
    public static function create()
    {
        foreach (Session::where('status', 'scheduled')->get() as $session) {
            if ($session->starts < Carbon::now() && $session->starts > Carbon::now()->subDay()) {
                foreach ($session->sessionPlayers as $sessionPlayer) {
                    $sessionPlayer->player->user->notify(new PlayerSessionReminderNotification($sessionPlayer->player->user->first_name, $session));
                }
            }
        }
    }
}

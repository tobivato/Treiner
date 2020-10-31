<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Illuminate\Console\Scheduling\Schedule;
use Treiner\Notifications\SessionLowPlayers;
use Treiner\Session;

class LowSessionReminder
{
    public static function create()
    {
            $now = \Carbon\Carbon::now();
            $sessions = Session::all()->where('sessionPlayers.count', '<', 'group_min');
            foreach ($sessions as $session) {
                if ($now->diffInHours($session->starts) < 72) {
                    foreach ($session->sessionPlayers() as $sessionPlayer) {
                        $sessionPlayer->player->user->notify(new SessionLowPlayers($session));
                    }
                }
            }
    }
}

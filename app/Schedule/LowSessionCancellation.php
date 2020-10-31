<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Treiner\Notifications\LowSessionCancellation as NotificationsLowSessionCancellation;
use Treiner\Payment\RefundHandler;
use Treiner\Session;

class LowSessionCancellation
{
    public static function create()
    {
            $now = \Carbon\Carbon::now();
            $sessions = Session::all();
            foreach ($sessions as $session) {
                if ($now > $session->starts->subHours(6) && (count($session->sessionPlayers) < $session->group_min)) {
                    foreach ($session->sessionPlayers as $sessionPlayer) {
                        $sessionPlayer->player->user->notify(new NotificationsLowSessionCancellation($session));
                        new RefundHandler($sessionPlayer, $sessionPlayer->player->user);
                    }
                    $session->delete();
                }
            }
    }
}

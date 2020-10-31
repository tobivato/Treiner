<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Carbon\Carbon;
use Treiner\Session;

class MarkSessionsCompleted {
    public static function create()
    {
        $sessions = Session::where('status', 'scheduled')->get();

        foreach ($sessions as $session) {
            if ($session->starts < Carbon::now()->subHours(12)) {
                $session->status = 'completed';
                $session->save();
            }
        }
    }
}
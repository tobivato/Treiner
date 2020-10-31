<?php

declare(strict_types=1);

namespace Treiner\Policies;

use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Treiner\Coach;
use Treiner\Player;
use Treiner\Session;
use Treiner\User;

class SessionPolicy
{
    use HandlesAuthorization;

    public function book(User $user, Session $session)
    {
        return !$session->full && $session->coach->verified && $user->role instanceof Player;
    }

    /**
     * Determine whether the user can create sessions.
     */
    public function create(User $user)
    {
        return $user->role instanceof Coach && $user->coach->verified;
    }

    public function view(User $user, Session $session)
    {
        return $session->coach->user == $user;
    }

    /**
     * Determine whether the user can update the session.
     */
    public function update(User $user, Session $session)
    {
        return $session->coach->user == $user;
    }

    public function payout(User $user, Session $session)
    {
        $sessionCanFinish = $session->starts->addMinutes($session->length) < Carbon::now();
        return $sessionCanFinish && ($user->id == $session->coach->user->id) && $session->status == 'scheduled';
    }

    /**
     * Determine whether the user can delete the session.
     */
    public function delete(User $user, Session $session)
    {
        return $session->coach->user == $user;
    }
}

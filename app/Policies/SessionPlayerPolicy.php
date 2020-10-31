<?php

namespace Treiner\Policies;

use Treiner\User;
use Treiner\SessionPlayer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;
use Treiner\Coach;
use Treiner\Player;
use Treiner\Session;

class SessionPlayerPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the session player.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\SessionPlayer  $sessionPlayer
     * @return mixed
     */
    public function withdraw(User $user, SessionPlayer $sessionPlayer)
    {
        return $sessionPlayer->player->user == $user;
    }

    public function createReportForCoach(User $user, Session $session)
    {
        return $session->coach == $user->coach;
    }

    public function createReportForPlayer(User $user, SessionPlayer $sessionPlayer)
    {
        $playerMatchesSession = ($sessionPlayer->player->user == $user);
        return $playerMatchesSession;
    }

}

<?php

declare(strict_types=1);

namespace Treiner\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Treiner\Coach;
use Treiner\Player;
use Treiner\User;

class CoachPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any coaches.
     *
     * @param \Treiner\User $user
     */
    public function viewAny(?User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the coach.
     *
     * @param \Treiner\User $user
     */
    public function view(?User $user = null, Coach $coach)
    {
        if ($user) {
            return $coach->verified || $user->role instanceof Coach;
        }
        else {
            return $coach->verified;
        }
    }

    public function book(User $user, Coach $coach)
    {
        return $user->role instanceof Player && $coach->verified;
    }

    /**
     * Determine whether the user can update the coach.
     */
    public function update(User $user, Coach $coach)
    {
        return $user->coach === $coach;
    }

    /**
     * Determine whether the user can delete the coach.
     */
    public function delete(User $user, Coach $coach)
    {
        return $user->coach === $coach;
    }

    /**
     * Determine whether the user can restore the coach.
     */
    public function restore(User $user, Coach $coach)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the coach.
     */
    public function forceDelete(User $user, Coach $coach)
    {
        return true;
    }
}

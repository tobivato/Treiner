<?php

declare(strict_types=1);

namespace Treiner\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Treiner\Player;
use Treiner\Review;
use Treiner\User;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reviews.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the review.
     */
    public function view(User $user, Review $review)
    {
        return $review->sessionPlayer->player->user === $user;
    }

    /**
     * Determine whether the user can create reviews.
     */
    public function create(User $user)
    {
        return $user->role instanceof Player;
    }

    /**
     * Determine whether the user can update the review.
     */
    public function update(User $user, Review $review)
    {
        return $review->sessionPlayer->player->user == $user;
    }

    /**
     * Determine whether the user can delete the review.
     */
    public function delete(User $user, Review $review)
    {
        return $review->sessionPlayer->player->user == $user;
    }
}

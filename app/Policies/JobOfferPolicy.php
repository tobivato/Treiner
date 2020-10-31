<?php

namespace Treiner\Policies;

use Treiner\User;
use Treiner\JobOffer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Treiner\Coach;
use Treiner\JobPost;

class JobOfferPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the job offer.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\JobOffer  $jobOffer
     * @return mixed
     */
    public function view(User $user, JobOffer $jobOffer)
    {
        return $jobOffer->jobPost->player->user == $user || $jobOffer->coach->user == $user;
    }

    /**
     * Determine whether the user can create job offers.
     *
     * @param  \Treiner\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role instanceof Coach && $user->coach->verified;
    }

    /**
     * Determine whether the user can update the job offer.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\JobOffer  $jobOffer
     * @return mixed
     */
    public function update(User $user, JobOffer $jobOffer)
    {
        return $jobOffer->coach->user == $user && $user->coach->verified;
    }

    public function finish(User $user, JobOffer $jobOffer)
    {
        return $jobOffer->jobPost->player->user == $user;
    }

    /**
     * Determine whether the user can delete the job offer.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\JobOffer  $jobOffer
     * @return mixed
     */
    public function delete(User $user, JobOffer $jobOffer)
    {
        return $jobOffer->jobPost->player->user == $user || $jobOffer->coach->user == $user;
    }
}

<?php

namespace Treiner\Policies;

use Treiner\User;
use Treiner\JobPost;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;
use Treiner\Coach;
use Treiner\Player;

class JobPostPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user)
    {
        return true;//optional($user)->role instanceof Coach && optional($user)->coach->verified;
    }

    /**
     * Determine whether the user can view the job post.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\JobPost  $jobPost
     * @return mixed
     */
    public function view(?User $user, JobPost $jobPost)
    {
        return true;//($jobPost->player->user == optional($user)) || (optional($user)->role instanceof Coach && optional($user)->coach->verified);
    }

    /**
     * Determine whether the user can create job posts.
     *
     * @param  \Treiner\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role instanceof Player;
    }

    /**
     * Determine whether the user can update the job post.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\JobPost  $jobPost
     * @return mixed
     */
    public function update(User $user, JobPost $jobPost)
    {
        return $jobPost->player->user == $user;
    }

    /**
     * Determine whether the user can delete the job post.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\JobPost  $jobPost
     * @return mixed
     */
    public function delete(User $user, JobPost $jobPost)
    {
        return $jobPost->player->user == $user;
    }
}

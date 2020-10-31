<?php

namespace Treiner\Policies;

use Treiner\User;
use Treiner\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can create comments.
     *
     * @param  \Treiner\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $comment->user == $user;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        return $comment->user == $user;
    }
}

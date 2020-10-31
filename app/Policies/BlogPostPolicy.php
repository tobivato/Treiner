<?php

declare(strict_types=1);

namespace Treiner\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Log;
use Treiner\BlogPost;
use Treiner\Coach;
use Treiner\User;

class BlogPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any blog posts.
     */
    public function viewAny(?User $user = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the blog post.
     */
    public function view(?User $user = null, BlogPost $blogPost)
    {
        return true;
    }

    /**
     * Determine whether the user can create blog posts.
     */
    public function create(User $user)
    {
        return ($user->role instanceof Coach && $user->coach->verified) || ($user->isAdmin());
    }

    /**
     * Determine whether the user can update the blog post.
     */
    public function update(User $user, BlogPost $blogPost)
    {
        if (($user->isAdmin()) || ($blogPost->coach && $blogPost->coach->user == $user)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the blog post.
     */
    public function delete(User $user, BlogPost $blogPost)
    {
        return ($user->isAdmin()) || ($blogPost->coach->user == $user);
    }
}

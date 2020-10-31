<?php

declare(strict_types=1);

namespace Treiner\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Treiner\BlogPost;
use Treiner\Camp;
use Treiner\CartItem;
use Treiner\Comment;
use Treiner\Session;
use Treiner\Coach;
use Treiner\Conversation;
use Treiner\Review;
use Treiner\JobOffer;
use Treiner\JobPost;
use Treiner\Policies\BlogPostPolicy;
use Treiner\Policies\CampPolicy;
use Treiner\Policies\CartItemPolicy;
use Treiner\Policies\CoachPolicy;
use Treiner\Policies\CommentPolicy;
use Treiner\Policies\ConversationPolicy;
use Treiner\Policies\JobOfferPolicy;
use Treiner\Policies\JobPostPolicy;
use Treiner\Policies\ReviewPolicy;
use Treiner\Policies\SessionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
        CartItem::class => CartItemPolicy::class, 
        Comment::class => CommentPolicy::class, 
        Session::class => SessionPolicy::class,
        Coach::class => CoachPolicy::class,
        Review::class => ReviewPolicy::class,
        JobOffer::class => JobOfferPolicy::class,
        JobPost::class => JobPostPolicy::class,
        Conversation::class => ConversationPolicy::class,
        Camp::class => CampPolicy::class,
    ];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}

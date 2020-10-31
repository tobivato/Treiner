<?php

declare(strict_types=1);

namespace Treiner\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Treiner\BlogPost;
use Treiner\Camp;
use Treiner\Coach;
use Treiner\Coupon;
use Treiner\CoachCamp;
use Treiner\Comment;
use Treiner\Conversation;
use Treiner\JobOffer;
use Treiner\JobPost;
use Treiner\Report;
use Treiner\Review;
use Treiner\Session;
use Treiner\SessionPlayer;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Treiner\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();

        Route::model('camp', Camp::class);
        Route::model('job', JobPost::class);
        Route::model('coach', Coach::class);
        Route::model('blog', BlogPost::class);
        Route::model('coupon', Coupon::class);
        Route::model('report', Report::class);
        Route::model('review', Review::class);
        Route::model('offer', JobOffer::class);
        Route::model('session', Session::class);
        Route::model('comment', Comment::class);
        Route::model('invitation', CoachCamp::class);
        Route::model('conversation', Conversation::class);
        Route::model('sessionPlayer', SessionPlayer::class);
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}

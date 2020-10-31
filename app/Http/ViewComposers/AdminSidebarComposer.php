<?php

namespace Treiner\Http\ViewComposers;

use Cache;
use Illuminate\View\View;

class AdminSidebarComposer
{
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        Cache::setPrefix(config('app.url'));

        $view->with([
            'reportsCount' => cache('admin.reports.count'), 
            'verificationsCount' => cache('admin.verifications.count'), 
            'adminsCount' => cache('admin.admins.count'), 
            'playersCount' => cache('admin.players.count'), 
            'coachesCount' => cache('admin.coaches.count'), 
            'sessionsCount' => cache('admin.sessions.count'),
            'jobPostCount' => cache('admin.job-posts.count'),
            'couponsCount' => cache('admin.coupons.count'),
        ]);
    }
}

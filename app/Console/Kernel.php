<?php

namespace Treiner\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Stripe\Account;
use Stripe\Stripe;
use Treiner\Coach;
use Treiner\Location;
use Treiner\Schedule\AdminDashboardCacheHandler;
use Treiner\Schedule\CityCacher;
use Treiner\Schedule\CoachSessionReminder;
use Treiner\Schedule\DeleteCoachesWithNoUser;
use Treiner\Schedule\LowSessionCancellation;
use Treiner\Schedule\LowSessionReminder;
use Treiner\Schedule\MarkSessionsCompleted;
use Treiner\Schedule\NearbyJobsReminder;
use Treiner\Schedule\OldJobPostCancellation;
use Treiner\Schedule\PlayerSessionReminder;
use Treiner\Schedule\ReviewReminder;
use Treiner\Schedule\SitemapGenerator;
use Treiner\User;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Send off review emails every day at 00:00
        $schedule->call(function() {
            ReviewReminder::create();
        })->hourly();
        //Check that all sessions with 3 days to go and not enough players have every player notified
        $schedule->call(function() {
            LowSessionReminder::create();
        })->hourly();
        //Cancel sessions without enough players a day beforehand
        $schedule->call(function() {
            LowSessionCancellation::create();
        })->hourly();
        //Update data for admin dashboard
        $schedule->call(function() {
            AdminDashboardCacheHandler::create();
        })->everyTenMinutes();
        //Generate sitemap
        $schedule->call(function() {
            SitemapGenerator::create();
        })->hourly();
        $schedule->call(function() {
            MarkSessionsCompleted::create();
        })->hourly();
        $schedule->call(function() {
            OldJobPostCancellation::create();
        })->hourly();
        $schedule->call(function() {
            CityCacher::create();
        })->hourly();
        $schedule->call(function() {
            PlayerSessionReminder::create();
        })->daily();
        //Remind coaches of nearby jobs
        $schedule->call(function() {
            NearbyJobsReminder::create();
        })->weekly()->sundays()->at('20:00');
        $schedule->call(function() {
            CoachSessionReminder::create();
        })->weekly()->wednesdays()->at('20:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

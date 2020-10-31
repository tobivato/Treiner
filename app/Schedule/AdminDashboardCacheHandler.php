<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Akaunting\Money\Currency;
use Cache;
use Carbon\Carbon;
use Treiner\Coach;
use Treiner\Coupon;
use Treiner\JobPost;
use Treiner\Payment;
use Treiner\Player;
use Treiner\Report;
use Treiner\Review;
use Treiner\Session;
use Treiner\SessionPlayer;
use Treiner\User;

class AdminDashboardCacheHandler
{
    public static function create()
    {
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
    
        Cache::setPrefix(config('app.url'));

        Cache::set('admin.reports.count', Report::where('resolved', false)->count());
        Cache::set('admin.verifications.count', Coach::where('verification_status', 'pending')->count());
        Cache::set('admin.coupons.count', Coupon::count());

        AdminDashboardCacheHandler::findSessionCount($now, $lastMonth);
        AdminDashboardCacheHandler::findCoachCount($now, $lastMonth);
        AdminDashboardCacheHandler::findPlayerCount($now, $lastMonth);
        AdminDashboardCacheHandler::findAdminCount();
        AdminDashboardCacheHandler::findSessionPlayerCount($now, $lastMonth);
        AdminDashboardCacheHandler::findJobPostCount($now, $lastMonth);
        AdminDashboardCacheHandler::findAverageReview($now, $lastMonth);
        AdminDashboardCacheHandler::findPayments($now, $lastMonth);
        AdminDashboardCacheHandler::calculateGraphData($now);
    }

    private static function findSessionCount($now, $lastMonth)
    {
        $sessionCount = Session::whereYear('starts', $now->year)->whereMonth('created_at', $now->month)->count();
        $sessionCountLastMonth = Session::whereYear('starts', $lastMonth->year)->whereMonth('starts', $lastMonth->month)->count();

        if ($sessionCount == 0) {
            $sessionsPerCoach = 0;
        }
        else {
            $sessionsPerCoach = $sessionCount / Coach::all()->where('verified')->count();
        }


        $sessionPlayersCount = (array_count_values(Player::withCount('sessionPlayers')->pluck('session_players_count')->toArray()));
        $sessionCoachCount = (array_count_values(Coach::withCount('sessions')->pluck('sessions_count')->toArray()));
        ksort($sessionPlayersCount);
        ksort($sessionCoachCount);

        Cache::set('admin.sessions.count', $sessionCount);
        Cache::set('admin.sessions.count-last-month', $sessionCountLastMonth);
        Cache::set('admin.sessions.count-per-coach', $sessionsPerCoach);
        Cache::set('admin.session-players.count-monthly', $sessionPlayersCount);
        Cache::set('admin.sessions.coach-count', $sessionCoachCount);
    }

    /**
     * Finds the count for all the coaches
     *
     * @param Carbon $now
     * @return void
     */
    private static function findCoachCount($now, $lastMonth) 
    {
        $coachesCount = Coach::count();
        $coachesLastMonthCount = Coach::whereDate('created_at', '<=', $lastMonth)->count();

        Cache::set('admin.coaches.count', $coachesCount);
        Cache::set('admin.coaches.count-last-month', $coachesLastMonthCount);
    }

    private static function findPlayerCount($now, $lastMonth)
    {
        $playersCount = Player::count();
        $playersLastMonthCount = Player::whereDate('created_at', '<=', $lastMonth)->count();

        Cache::set('admin.players.count', $playersCount);
        Cache::set('admin.players.count-last-month', $playersLastMonthCount);
    }

    private static function findSessionPlayerCount($now, $lastMonth)
    {
        $bookedSessions = SessionPlayer::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $bookedSessionsLastMonth = SessionPlayer::whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
    
        Cache::set('admin.session-players.count', $bookedSessions);
        Cache::set('admin.session-players.count-last-month', $bookedSessionsLastMonth);
    }

    private static function findAdminCount()
    {
        $adminCount = User::where('permissions', 'admin')->count();
        Cache::set('admin.admins.count', $adminCount);
    }

    private static function findJobPostCount($now, $lastMonth) 
    {
        $jobPostCount = JobPost::whereYear('starts', $now->year)->whereMonth('starts', $now->month)->count();
        $jobPostCountLastMonth = JobPost::whereYear('starts', $lastMonth->year)->whereMonth('starts', $lastMonth->month)->count();

        Cache::set('admin.job-posts.count', $jobPostCount);
        Cache::set('admin.job-posts.count-last-mont', $jobPostCountLastMonth);
    }

    private static function findAverageReview($now, $lastMonth)
    {
        $reviews = Review::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month);
        $averageReview = $reviews->avg('rating');
        $reviewCount = $reviews->count();
        $averageReviewLastMonth = Review::whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->avg('rating');

        Cache::set('admin.reviews.count', $reviewCount);
        Cache::set('admin.reviews.average', $averageReview);
        Cache::set('admin.reviews.average-last-month', $averageReviewLastMonth);
    }

    /**
     * Finds the total payments
     *
     * @param Carbon $now
     * @param Carbon $lastMonth
     * @return void
     */
    private static function findPayments($now, $lastMonth) 
    {
        $payments = [];
        $audTotal = money(0, 'AUD', true);

        foreach (config('treiner.countries') as $country) {
            $current = money(Payment::whereCurrency($country['currency'])->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount'), $country['currency']);
            $last = money(Payment::whereCurrency($country['currency'])->whereYear('created_at', $lastMonth->clone()->year)->whereMonth('created_at', $lastMonth->clone()->month)->sum('amount'), $country['currency']);
  
            $payments[$country['currency']]['current'] = $current->format();
            $payments[$country['currency']]['diff'] = $current->subtract($last)->isPositive() ? '+' . $current->subtract($last)->format() : $current->subtract($last)->format();
            
            $current = $current->convert(Currency::AUD(), $country['aud_conversion_rate']);
            $audTotal = $audTotal->add($current);
        }

        Cache::set('admin.payments', $payments);
        Cache::set('admin.total', $audTotal);
    }

    private static function calculateGraphData($now)
    {
        $graphData = [];
        $now = $now->clone();
        for ($i=0; $i < 12; $i++) { 
            $graphData['sessions'][$now->monthName . ' ' . $now->year] = SessionPlayer::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
            $graphData['jobPosts'][$now->monthName . ' ' . $now->year] = JobPost::withTrashed()->whereYear('starts', $now->year)->whereMonth('starts', $now->month)->count();
            $graphData['players'][$now->monthName . ' ' . $now->year] = Player::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
            $graphData['coaches'][$now->monthName . ' ' . $now->year] = Coach::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
            $now->subMonth();
        }
        $graphData['sessions'] = array_reverse($graphData['sessions']);
        $graphData['jobPosts'] = array_reverse($graphData['jobPosts']);
        $graphData['players'] = array_reverse($graphData['players']);
        $graphData['coaches'] = array_reverse($graphData['coaches']);

        Cache::set('admin.session.graph-data', $graphData);
    }
}
 
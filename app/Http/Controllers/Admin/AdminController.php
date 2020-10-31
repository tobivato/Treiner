<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers\Admin;

use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;
use Treiner\Http\Controllers\Controller;
use Treiner\User;
use Treiner\Player;
use Treiner\Schedule\AdminDashboardCacheHandler;

class AdminController extends Controller
{
    public function admins()
    {
        return view('admin.admins.index', ['admins' => (User::where('permissions', 'admin')->paginate(20))]);
    }

    public function dashboard()
    {
        Cache::setPrefix(config('app.url'));
        if (!cache('admin.players.count')) { //make it so if it hasn't been scheduled update the dashboard
            AdminDashboardCacheHandler::create();
        }
        return view('admin.dashboard', [
            'coachCount' => cache('admin.coaches.count'),
            'playerCount' => cache('admin.players.count'),
            'coachCountLastMonth' => cache('admin.coaches.count-last-month'),
            'playerCountLastMonth' => cache('admin.players.count-last-month'),
            'reports' => cache('admin.reports.count'),
            'verifications' => cache('admin.verifications.count'), 
            'averageReview' => cache('admin.reviews.average'), 
            'reviewCount' => cache('admin.reviews.count'),
            'averageReviewLastMonth' => cache('admin.reviews.average-last-month'),
            'sessionCount' => cache('admin.sessions.count'),
            'sessionCountLastMonth' => cache('admin.sessions.count-last-month'),
            'sessionsPerCoach' => cache('admin.sessions.count-per-coach'),
            'jobPostCount' => cache('admin.job-posts.count'),
            'jobPostCountLastMonth' => cache('admin.job-posts.count-last-month'),
            'payments' => cache('admin.payments'),
            'bookedSessions' => cache('admin.session-players.count'),
            'bookedSessionsLastMonth' => cache('admin.session-players.count-last-month'),
            'graphData' => cache('admin.session.graph-data'),
            'audTotal' => cache('admin.total'),
            'sessionPlayersCount' => cache('admin.session-players.count-monthly'),
            'sessionCoachCount' => cache('admin.sessions.coach-count'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'string|min:32',
        ]);
        $role = Player::create();

        $user = new User;
        
        $user->fill([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => null,
            'gender' => 'male',
            'password' => bcrypt($request->input('password')),
            'currency' => 'AUD',
            'image_id' => 'profile-none',
            'dob' => '1900-01-01',
        ]);

        $user->role_id = $role->id;
        $user->role_type = 'Treiner\Player';
        $user->email = $request->input('email');
        $user->email_verified_at = \Carbon\Carbon::now();

        $user->permissions = 'admin';
        $user->save();

        return redirect(route('admins.index'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.admins.edit', ['user' => $user]);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        $request->validate([
            'password' => 'string|min:32',
        ]);   

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');
        $user->save();
        return redirect(route('admins.index'));
    }

    public function destroy($id, Request $request)
    {
        $user = User::find($id);
        $user->forceDelete();
        return redirect(route('admins.index'));
    }
}

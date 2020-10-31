<?php

namespace Treiner\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Treiner\Coach;
use Treiner\Http\Controllers\Controller;
use Treiner\User;
use Treiner\Notifications\CoachAccepted;
use Treiner\Notifications\CoachDenied;
use Illuminate\View\View;
use Log;

class CoachController extends Controller
{
    public function showSearchForm()
    {
        $coaches = Coach::paginate(25);
        return view('admin.coaches.search', ['coaches' => $coaches]);
    }

    public function searchById(Request $request)
    {
        return redirect(route('admin.coaches.show', $request->input('query')));
    }

    public function searchByName(Request $request) : View
    {
        $results = User::where('role_type', 'Treiner\Coach')->get();
        
        $query = $request->input('query');

        $results = $results->reject(function($element) use ($query) {
            return mb_strpos(strtolower($element->name), strtolower($query)) === false;
        });

        return view('admin.coaches.search', ['coaches' => $results]);
    }

    public function updateFee(Request $request, Coach $coach)
    {
        $request->validate([
            'fee' => 'required|integer|between:0,100',
        ]);
        $coach->treiner_fee = $request->input('fee');
        $coach->save();
        return redirect(route('admin.coaches.show', $coach))->with('message', 'Coach fee updated.');
    }

    public function updateVerified(Request $request, Coach $coach)
    {
        $request->validate([
            'verification_status' => 'required|in:verified,denied',
        ]);
        $coach->verification_status = $request['verification_status'];
        $coach->save();
        return redirect(route('admin.coaches.show', $coach))->with('message', 'Coach verification status updated.');
    }

    public function show(Coach $coach)
    {
        return view('admin.coaches.show', ['coach' => $coach]);
    }

    public function showVerifications()
    {
        return view('admin.verification.index', ['coaches' => Coach::where('verification_status', 'pending')->paginate(20)]);
    }

    public function saveCoachesAsCsv()
    {
        $coaches = Coach::where('verification_status', 'verified')->get();
        $data = [];

        foreach ($coaches as $coach) {
            $coachData = [
                'coach_id' => $coach->id,
                'name' => $coach->user->name,
                'email' => $coach->user->email,
                'phone' => $coach->user->phone,
                'date_of_birth' => $coach->user->dob,
            ];
            array_push($data, $coachData);
        }
        $csv = new \mnshankar\CSV\CSV();
        return $csv->fromArray($data)->render('coaches-' . Carbon::now()->format('c') . '.csv');
    }

    public function saveVerificationsAsCsv()
    {
        $verifications = [];
        $coaches = Coach::where('verification_status', 'pending')->get();

        foreach ($coaches as $coach) {
            $data = [
                'name' => $coach->user->name,
                'email' => $coach->user->email,
                'phone' => $coach->user->phone,
                'coach_id' => $coach->id,
                'date_of_birth' => $coach->user->dob,
                'club' => $coach->club,
                'verification_data' => [],
            ];

            foreach ($coach->verifications as $verification) {
                array_push($data['verification_data'], [
                    'type' => $verification->verification_type,
                    'number' => $verification->verification_number,
                ]);
            }
            array_push($verifications, $data);
        }

        $csv = new \mnshankar\CSV\CSV();
        return $csv->fromArray($verifications)->render('verifications-' . Carbon::now()->format('c') . '.csv');
    }

    public function acceptCoach(Request $request)
    {
        $coach = Coach::find($request->input('coach_id'));
        $coach->verification_status = 'verified';
        $coach->save();

        $coach->user->notify(new CoachAccepted());

        return redirect(route('verifications.index'));
    }

    public function denyCoach(Request $request)
    {
        $request->validate([
            'deny_reason' => 'required|string|max:100',
            'coach_id' => 'required|integer'
        ]);
        $coach = Coach::findOrFail($request->input('coach_id'));
        $coach->verification_status = 'denied';
        $coach->save();
        $denyReason = $request->input('deny_reason', 'No reason given');

        $coach->user->notify(new CoachDenied($denyReason));

        return redirect(route('verifications.index'));
    }
}

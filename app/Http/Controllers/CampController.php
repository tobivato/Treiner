<?php

namespace Treiner\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Cloudder;
use DB;
use Treiner\Camp;
use Illuminate\Http\Request;
use Treiner\Coach;
use Treiner\CoachCamp;
use Treiner\Location;
use Treiner\Payment\RefundHandler;
use Treiner\Session;

class CampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $camps = Camp::paginate(24);
        return view('camps.index', ['camps' => $camps]);
    }


    public function csv(Camp $camp)
    {
        /*
            Since eloquent will NOT provide the same instance of a Model everytime you query for it.
            is medthod is used to compare the database table, and id.

        */
        if (!$camp->session->coach->user->is(Auth::user())) {
            abort(403);
        }

        $array = [];
        foreach ($camp->session->sessionPlayers as $sessionPlayer) {
            $array = array_merge($array, $sessionPlayer->player_info);
        }

        $csv = new \mnshankar\CSV\CSV();
        return $csv->fromArray($array)->render(crc32($camp->id) . '.csv');
    }

    public function dashboard()
    {
        return view('dashboard.coach.camps');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!($user->role instanceof Coach && $user->coach->verified)) {
            abort(403);
        }
        $request->validate([
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'street_address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'starts' => 'required|date|after:now|before:+80 days',
            'days' => 'required|integer|min:1|max:30',
            'start-time' => 'required|date_format:H:i',
            'end-time' => 'required|date_format:H:i',
            'fee' => 'required|max:99999999|min:1.00',
            'group_min' => 'required|integer|min:1|max:500|lte:group_max',
            'group_max' => 'required|integer|min:1|max:500|gte:group_min',
            'title' => 'required|string|max:50',
            'ages' => 'required|array',
            'description' => 'required|string|max:5000',
            'tos' => 'required|string|max:10000',
            'image' => ['required', 'image', 'max:20000'],
            'coaches' => ['nullable', 'array'],
            'coaches.*' => 'integer',
        ]);
        $camp = null;
        DB::transaction(function() use ($request, &$camp) {
            $location = Location::create([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'street_address' => $request->input('street_address'),
                'locality' => $request->input('locality'),
                'country' => $request->input('country'),
            ]);

            $starts = new Carbon($request->input('starts'));

            $carbon = new Carbon();

            $startTime = $carbon->createFromFormat('H:i', $request->input('start-time'));
            $endTime = $carbon->createFromFormat('H:i', $request->input('end-time'));

            $length = ($startTime->diffInMinutes($endTime)) * $request->input('days');

            $session = Session::create([
                'coach_id' => Auth::user()->coach->id,
                'location_id' => $location->id,
                'length' => $length,
                'starts' => $starts,
                'fee' => intval(($request->input('fee') * 100) / ($length / 60)),
                'group_min' => $request->input('group_min'),
                'group_max' => $request->input('group_max'),
                'type' => 'Camp',
            ]);

            $camp = Camp::create([
                'session_id' => $session->id,
                'image_id' => Cloudder::upload($request->file('image'))->getPublicId(),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'tos' => $request->input('tos'),
                'ages' => $request->input('ages'),
                'start_time' => $request->input('start-time'),
                'end_time' => $request->input('end-time'),
                'days' => $request->input('days'),
            ]);

            if ($request->input('coaches')) {
                foreach ($request->input('coaches') as $coach) {
                    CoachCamp::create([
                        'coach_id' => $coach,
                        'camp_id' => $camp->id,
                    ]);
                }
            }
        });
        return redirect(route('camps.show', $camp))->with('message', 'Camp successfully created.');
    }

    public function invitations()
    {
        $campInvitations = Auth::user()->coach->campInvitations->where('accepted_at', null);
        $jobInvitations = Auth::user()->coach->jobInvitations;
        return view('dashboard.coach.invitations', ['campInvitations' => $campInvitations, 'jobInvitations' => $jobInvitations]);
    }

    public function acceptInvitation(CoachCamp $invitation)
    {
        if($invitation->coach->user != Auth::user()) {
            abort(403);
        }
        $invitation->accepted_at = Carbon::now();
        $invitation->save();
        return redirect(route('invitations.index'))->with('message', 'Invitation accepted.');
    }

    public function denyInvitation(CoachCamp $invitation)
    {
        if($invitation->coach->user != Auth::user()) {
            abort(403);
        }
        $invitation->delete();
        return redirect(route('invitations.index'))->with('message', 'Invitation denied.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Treiner\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function show(Camp $camp)
    {
        $invitations = $camp->invitations->where('accepted_at');
        return view('camps.show', ['camp' => $camp, 'invitations' => $invitations]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Treiner\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function edit(Camp $camp)
    {
        if ($camp->session->coach->user != Auth::user()) {
            abort(403);
        }
        return view('camps.edit', ['camp' => $camp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Treiner\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camp $camp)
    {
        if ($camp->session->coach->user != Auth::user()) {
            abort(403);
        }
        $request->validate([
            'latitude' => 'nullable|numeric|min:-90|max:90',
            'longitude' => 'nullable|numeric|min:-180|max:180',
            'street_address' => 'nullable|string|max:255',
            'locality' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'starts' => 'nullable|date|after:now|before:+80 days',
            'days' => 'nullable|integer|min:1|max:30',
            'start-time' => 'nullable|required_with:end-time|date_format:H:i',
            'end-time' => 'nullable|required_with:start-time|date_format:H:i',
            'fee' => 'nullable|max:99999999|min:1.00',
            'group_min' => 'nullable|integer|min:1|max:500|lte:group_max',
            'group_max' => 'nullable|integer|min:1|max:500|gte:group_min',
            'title' => 'nullable|string|max:50',
            'ages' => 'nullable|array',
            'description' => 'nullable|string|max:5000',
            'tos' => 'nullable|string|max:10000',
            'image' => ['nullable', 'image', 'max:8191'],
            'coaches' => ['nullable', 'array'],
            'coaches.*' => 'integer',
        ]);

        $camp->session->location->update($request->all());

        $camp->session->update($request->all());

        $camp->update($request->all());

        if ($request->has('image')) {
            $camp->image_id = Cloudder::upload($request->file('image'))->getPublicId();
        }

        if ($request->input('coaches')) {
            foreach ($request->input('coaches') as $coach) {
                CoachCamp::create([
                    'coach_id' => $coach,
                    'camp_id' => $camp->id,
                ]);
            }
        }

        return redirect(route('dashboard.camps'))->with('message', 'Camp successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Treiner\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camp $camp)
    {
        $camp->invitations->delete();

        foreach ($camp->session->sessionPlayers as $sessionplayer) {
            $refunder = new RefundHandler($sessionplayer, Auth::user());
            $refunder->notifyCancellation($sessionplayer->player);
        }

        $camp->session->delete();
        $camp->delete();

        return redirect(route('camps.dashboard'))->with('message', 'Camp deleted.');
    }
}

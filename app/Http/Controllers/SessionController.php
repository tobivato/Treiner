<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use Exception;
use Auth;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Log;
use Recurr\Rule as RecurrRule;
use Recurr\Transformer\ArrayTransformer;
use Recurr\Transformer\ArrayTransformerConfig;
use Treiner\Payment\RefundHandler;
use Treiner\Location;
use Treiner\Payment\SessionCompletionHandler;
use Treiner\Session;
use Treiner\SessionPlayer;

class SessionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //Can only access controller functions while authenticated
        $this->middleware('auth');
        $this->authorizeResource(Session::class, 'session');
    }

    public function show(Session $session)
    {
        return view('dashboard.coach.session', ['session' => $session]);
    }

    /**
     * Display a listing of sessions to the player
     */
    public function index(): \Illuminate\View\View
    {
        return view('dashboard.player.sessions');
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'street_address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'length' => 'required|integer|max:180|min:30',
            'starts' => 'required|date|after:now|before:+80 days',
            'fee' => 'required|max:99999999|min:1.00',
            'group_min' => 'required|integer|min:1|max:50|lte:group_max',
            'group_max' => 'required|integer|min:1|max:50|gte:group_min',
            'type' => ['required', Rule::in(config('treiner.sessions'))],
            'recurring_change' => 'sometimes',
            'recur' => 'required_with:recurring_change|in:daily,second-day,weekly,fortnightly,monthly',
            'recur_for' => 'required_with:recurring_change',
            'hourly_recurrence' => 'nullable',
            'hourly_recur_for' => 'required_with:hourly_recurrence',
        ]);

        DB::transaction(function() use($request) {
            $addRecurrences = function (\Recurr\RecurrenceCollection $recurrences, Request $request, $location)
            {
                foreach ($recurrences as $r) {
                    Session::create([
                        'coach_id' => Auth::user()->coach->id,
                        'location_id' => $location->id,
                        'length' => $request->input('length'),
                        'starts' => $r->getStart(),
                        'fee' => (int) ($request->input('fee') * 100),
                        'group_min' => $request->input('group_min'),
                        'group_max' => $request->input('group_max'),
                        'type' => ($request->input('type')),
                        'supports_cash_payments' => $request->has('cash-payments') ? true : false,
                    ]);
                }
            };

            $addHourlyRecurrences = function ($request, $time, $location) {
                $initialTime = $time->clone();
                for ($i=0; $i < $request->input('hourly_recur_for'); $i++) { 
                    $initialTime = $initialTime->addMinutes($request->input('length'));

                    Session::create([
                        'coach_id' => Auth::user()->coach->id,
                        'location_id' => $location->id,
                        'length' => $request->input('length'),
                        'starts' => $initialTime,
                        'fee' => (int) ($request->input('fee') * 100),
                        'group_min' => $request->input('group_min'),
                        'group_max' => $request->input('group_max'),
                        'type' => ($request->input('type')),
                        'supports_cash_payments' => $request->has('cash-payments') ? true : false,
                    ]);
                }  
            };

            $location = Location::create([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'street_address' => $request->input('street_address'),
                'locality' => $request->input('locality'),
                'country' => $request->input('country'),
            ]);

            Session::create([
                'coach_id' => Auth::user()->coach->id,
                'location_id' => $location->id,
                'length' => $request->input('length'),
                'starts' => new \Carbon\Carbon($request->input('starts')),
                'fee' => (int) ($request->input('fee') * 100),
                'group_min' => $request->input('group_min'),
                'group_max' => $request->input('group_max'),
                'type' => ($request->input('type')),
                'supports_cash_payments' => $request->has('cash-payments') ? true : false,
            ]);

            if ($request->input('hourly_recurrence')) {
                $addHourlyRecurrences($request, new \Carbon\Carbon($request->input('starts')), $location);
            }

            if ($request->input('recurring_change')) {
                $rule = (new RecurrRule)
                    ->setStartDate(new DateTime($request->input('starts'), new DateTimeZone(config('app.timezone'))))
                    ->setTimezone(config('app.timezone'));
                $transformer = new ArrayTransformer();

                switch ($request->input('recur')) {
                    case 'daily':
                        $rule->setFreq('DAILY');
                        break;
                    case 'second-day':
                        $rule = $rule
                            ->setFreq('DAILY')
                            ->setInterval(2);
                        break;
                    case 'weekly':
                        $rule = $rule->setFreq('WEEKLY');
                        break;
                    case 'fortnightly': 
                        $rule = $rule
                            ->setFreq('WEEKLY')
                            ->setInterval(2);
                        break;
                    case 'monthly':
                        $rule = $rule->setFreq('MONTHLY');
                        break;
                    default:
                        throw new Exception('Invalid settings for recurrence', 500);
                        break;
                }
                $rule->setCount($request->input('recur_for'));
                $recurrences = $transformer->transform($rule);

                $addRecurrences($recurrences, $request, $location);

                if ($request->input('hourly_recurrence')) {
                    foreach ($recurrences as $r) {
                        $initialTime = Carbon::instance($r->getStart());

                        $addHourlyRecurrences($request, $initialTime, $location);
                    }
                }
            }

            Auth::user()->coach->save();
        });

        return redirect(route('home'));
    }

    public function payout(Session $session) 
    {
        if (!(Auth::user()->can('payout', $session))) {
            return redirect(back())->with('message', 'You cannot payout this session.');
        }

        new SessionCompletionHandler($session);

        return redirect(route('home'))->with('message', 'Your session has been paid out.');
    }

    /**
     * Cancel a session and send notifications to the players.
     */
    public function destroy(Session $session)
    {
        //Creates a new refund for each player of a session
        foreach ($session->sessionPlayers as $sessionplayer) {
            $refunder = new RefundHandler($sessionplayer, Auth::user());
            $refunder->notifyCancellation($sessionplayer->player);
        }
        
        $session->delete();

        return redirect(route('home'));
    }

    /**
     * Destroys a sessionplayer, therefore removing the player from a session
     */
    public function withdraw(SessionPlayer $sessionPlayer)
    {
        $refunder = new RefundHandler($sessionPlayer, Auth::user());
        $refunder->notifyWithdrawal($sessionPlayer->player, $sessionPlayer->session->coach);

        $sessionPlayer->session->coach->save(); //Update Algolia search index

        return redirect(route('sessions.index'));
    }
}

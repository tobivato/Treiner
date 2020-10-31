<?php

namespace Treiner\Http\Controllers\Admin;

use Auth;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Recurr\Rule as RecurrRule;
use Recurr\Transformer\ArrayTransformer;
use Treiner\Coach;
use Treiner\Http\Controllers\Controller;
use Treiner\Location;
use Treiner\Session;

class SessionController extends Controller
{
    public function showSearchForm()
    {
        return view('admin.sessions.search', ['sessions' => Session::orderBy('starts')->paginate(25)]);
    }

    public function search(Request $request)
    {
        return redirect(route('admin.sessions.show', $request->input('query')));
    }

    public function create()
    {
        return view('admin.sessions.create');
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
            $coach = Coach::findOrFail($request->input('coach-id'));

            $addRecurrences = function (\Recurr\RecurrenceCollection $recurrences, $request, $location, $coach)
            {
                foreach ($recurrences as $r) {
                    Session::create([
                        'coach_id' => $coach->id,
                        'location_id' => $location->id,
                        'length' => $request->input('length'),
                        'starts' => $r->getStart(),
                        'fee' => (int) ($request->input('fee') * 100),
                        'group_min' => $request->input('group_min'),
                        'group_max' => $request->input('group_max'),
                        'type' => ($request->input('type')),
                    ]);
                }
            };

            $addHourlyRecurrences = function ($request, $time, $location, $coach) {
                $initialTime = $time->clone();
                for ($i=0; $i < $request->input('hourly_recur_for'); $i++) { 
                    $initialTime = $initialTime->addMinutes($request->input('length'));

                    Session::create([
                        'coach_id' => $coach->id,
                        'location_id' => $location->id,
                        'length' => $request->input('length'),
                        'starts' => $initialTime,
                        'fee' => (int) ($request->input('fee') * 100),
                        'group_min' => $request->input('group_min'),
                        'group_max' => $request->input('group_max'),
                        'type' => ($request->input('type')),
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
                'coach_id' => $coach->id,
                'location_id' => $location->id,
                'length' => $request->input('length'),
                'starts' => new \Carbon\Carbon($request->input('starts')),
                'fee' => (int) ($request->input('fee') * 100),
                'group_min' => $request->input('group_min'),
                'group_max' => $request->input('group_max'),
                'type' => ($request->input('type')),
            ]);

            if ($request->input('hourly_recurrence')) {
                $addHourlyRecurrences($request, new \Carbon\Carbon($request->input('starts')), $location, $coach);
            }

            if ($request->input('recurring_change')) {
                $rule = (new RecurrRule())
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

                $addRecurrences($recurrences, $request, $location, $coach);

                if ($request->input('hourly_recurrence')) {
                    foreach ($recurrences as $r) {
                        $initialTime = Carbon::instance($r->getStart());

                        $addHourlyRecurrences($request, $initialTime, $location, $coach);
                    }
                }
            }

            $coach->save();
        });
        return redirect(route('admin.sessions.search'));
    }

    public function show(Session $session)
    {
        return view('admin.sessions.show', ['session' => $session]);
    }
}

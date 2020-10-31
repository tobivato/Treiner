<?php

namespace Treiner\Http\Controllers;

use Arr;
use Treiner\JobPost;
use Illuminate\Http\Request;
use Treiner\Location;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Auth;
use Carbon\Carbon;
use DateTime;
use DB;
use Gahlawat\Slack\Facade\Slack;
use Log;
use Treiner\BillingAddress;
use Treiner\Coach;
use Treiner\Http\Requests\BillingRequest;
use Treiner\Http\Requests\JobPostRequest;
use Treiner\JobInvitation;
use Treiner\JobOffer;
use Treiner\NewsletterSubscription;
use Treiner\Notifications\JobPostedNotification;
use Treiner\Notifications\JobPostInvitation;
use Treiner\Notifications\NewJobNearCoach;
use Treiner\Payment\PaymentHandler;

class JobPostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(JobPost::class, 'job');
    }

    public function showSearchForm()
    {
        return view('jobs.index', ['jobs' => JobPost::paginate(25)]);
        //return view('jobs.welcome');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'lat' => 'required|numeric|min:-90|max:90',
            'lng' => 'required|numeric|min:-180|max:180',
            'distance' => 'required|integer|min:5|max:200',
            'location' => 'required|string|max:512',
            'price' => 'required',
        ]);
        $query = $request->input('search');
        $lat = floatval($request->input('lat'));
        $lng = floatval($request->input('lng'));
        $radius = intval($request->input('distance') * 1000);
        $location = $request->input('location');
        $price = $request->input('price');
        $lowPrice = 0;
        $highPrice = 50000;

        if ($price != 'any') {
            $lowPrice = intval(explode('-', $price, 2)[0]) * 100;
            $highPrice = intval(explode('-', $price, 2)[1]) * 100;
        }

        $jobs = JobPost::search($query)
            ->whereBetween('fee', [$lowPrice, $highPrice])
            ->aroundLatLng($lat, $lng)
            ->with(['aroundRadius' => $radius])
            ->paginate(24);

        return view('jobs.search', [
            'jobs' => $jobs,
            'query' => $query,
            'lat' => $lat,
            'lng' => $lng,
            'price' => $price,
            'distance' => $request->input('distance'),
            'location' => $location,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    public function requestSession(Coach $coach)
    {
        return view('jobs.request-session', ['coach' => $coach]);
    }

    public function index()
    {
        if (Auth::user()->role instanceof Coach) {
            abort(403);
        }
        return view('dashboard.player.jobs', ['jobPosts' => Auth::user()->player->jobPosts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JobPostRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function() use ($validated){
            $location = Location::create([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'locality' => $validated['locality'],
                'country' => $validated['country'],
            ]);

            $time = DateTime::createFromFormat('H:i', $validated['time']);
            
            $jobPost = JobPost::create([
                'title' => ucfirst($validated['title']),
                'player_id' => Auth::user()->player->id,
                'location_id' => $location->id,
                'starts' => (new Carbon($validated['starts']))->addHours($time->format('H'))->addMinutes($time->format('i')), //Hacky but it wasn't working otherwise
                'length' => $validated['length'],
                'details' => $validated['details'],
                'fee' => (int)($validated['fee'] * 100),
                'type' => $validated['type'],
            ]);

            if (Arr::has($validated, 'invite_coach')) {
                $jobInvitation = JobInvitation::create([
                    'job_post_id' => $jobPost->id,
                    'coach_id' => $validated['invite_coach'],
                ]);
                $coach = Coach::find($validated['invite_coach']);

                $coach->user->notify(new JobPostInvitation($jobInvitation));
            }

            else {
                $coaches = Coach::search()
                    ->aroundLatLng( $jobPost->location->latitude, $jobPost->location->longitude)
                    ->with(['aroundRadius' => 30000])->get();
                
                foreach ($coaches as $coach) {
                    $coach->user->notify(new NewJobNearCoach($jobPost));
                    Log::info($coach->user->name . ' notified of new job post.');
                }
            }
            
            $jobPost->save();
            Slack::send('New job posted by ' . Auth::user()->name . '. ' . route('admin.jobs.show', $jobPost));
        });

        $user = Auth::user();
        $user->notify(new JobPostedNotification());

        return redirect(route('jobs.index') . '?postcomplete=true')->with('message', 'Your job post has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Treiner\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function show(JobPost $jobPost) : View
    {
        return view('jobs.show', ['jobPost' => $jobPost]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Treiner\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function edit(JobPost $jobPost) : View
    {
        return view('jobs.edit', ['jobPost' => $jobPost]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Treiner\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPost $jobPost)
    {
        $request->validate([
            'title' => 'required|string|max:32',
            'type' => ['required', Rule::in(config('treiner.sessions'))],
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'locality' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'length' => 'required|integer|max:180|min:30',
            'starts' => 'required|date|after:now|before:+80 days',
            'fee' => 'required|numeric|max:25000|min:0.50',
            'details' => 'required|max:5000|min:50|string',
        ]);

        $request['starts'] = Carbon::createFromFormat('Y-m-d\TH:i',$request['starts']);

        $jobPost->location->update($request->all());
        $jobPost->update($request->all());
        $jobPost->fee = intval($request->input('fee') * 100);
        $jobPost->save(); //updates Algolia

        return redirect(route('jobs.index'))
                ->with('message', 'Your job has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Treiner\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPost $jobPost)
    {
        $jobPost->jobOffers()->delete();
        $jobPost->invitations()->delete();
        $jobPost->delete();
        return redirect(route('home'))->with('message', 'Your job has been successfully deleted');
    }

    public function complete(BillingRequest $request, JobOffer $jobOffer)
    {
        $validated = $request->validated();

        $players = [];
            
        for ($i=0; $i < count($validated['players-name']); $i++) { 
            array_push($players, [
                 'name' => $validated['players-name'][$i], 
                 'age' => $validated['players-age'][$i], 
                 'medical' => $validated['players-medical'][$i]
            ]);
        }

        $token = $validated['stripeToken'];

        $billingAddress = BillingAddress::create([
            'first_name' => $validated['firstName'], 
            'last_name' => $validated['lastName'],
            'street_address' => $validated['streetAddress'],
            'locality' => $validated['locality'],
            'country' => $validated['country'],  
            'state' => $validated['state'], 
            'postcode' => $validated['postcode'],
        ]);

        $paymentHandler = new PaymentHandler($token, $billingAddress, $players);

        $paymentHandler->fromJobPost(Auth::user()->player, $jobOffer);

        return view('cart.purchase-complete');
    }
}

<?php

namespace Treiner\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Treiner\Conversation;
use Treiner\JobOffer;
use Treiner\JobPost;
use Treiner\Location;
use Treiner\Notifications\JobApplication;

class JobOfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(JobOffer::class, 'offer');
    }

    /**
     * Show the form for a coach to create a new job offer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(JobPost $jobPost)
    {
        return view('jobs.offers.create', ['jobPost' => $jobPost]);
    }

    /**
     * Shows the job offers page for a coach.
     *
     * @return void
     */
    public function index()
    {
        return view('dashboard.coach.jobs', ['jobOffers' => Auth::user()->coach->jobOffers]);
    }

    /**
     * Submits a new job application from the coach to the player.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_post_id' => 'required|integer',
            'content' => 'required|string|min:50|max:5000',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'street_address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'country' => 'required|string|max:255',            
            'fee' => 'required|max:99999999|min:0.50',
        ]);

        DB::transaction(function() use ($request){
            $location = Location::create([
                'latitude' => $request['latitude'], 
                'longitude' => $request['longitude'], 
                'street_address' => $request['street_address'], 
                'locality' => $request['locality'], 
                'country' => $request['country'],
            ]);

            $jobPost = JobPost::findOrFail($request->input('job_post_id'));
            $coach = Auth::user()->coach;

            $jobOffer = JobOffer::create([
                'job_post_id' => $jobPost->id,
                'coach_id' => $coach->id,
                'location_id' => $location->id,
                'fee' => (int)($request->input('fee')) * 100,
                'content' => $request->input('content'),
            ]);

            Conversation::create([
                'from_id' => Auth::user()->id,
                'to_id' => $jobPost->player->user->id,
                'subject' => $jobPost->title,
            ]);

            $jobPost->player->user->notify(new JobApplication($jobOffer));
        });

        return redirect(route('offers.index'))->with('message', 'You have successfully submitted your job application.');
    }

    /**
     * Allows a user to deny a coach's offer for their job.
     *
     * @param JobOffer $jobOffer
     * @return void
     */
    public function deny(JobOffer $jobOffer)
    {
        $jobOffer->status = 'declined';
        $jobOffer->save();

        return redirect(route('jobs.index'))->with('message', 'The offer has been declined.');
    }

    /**
     * Shows the player a billing form for a specific job offer.
     *
     * @param JobOffer $jobOffer
     * @return void
     */
    public function showBillingForm(JobOffer $jobOffer)
    {
        return view('jobs.billing', ['jobOffer' => $jobOffer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOffer $jobOffer)
    {
        return view('jobs.offers.edit', ['jobOffer' => $jobOffer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        $request->validate([
            'job_post_id' => 'nullable|integer',
            'content' => 'nullable|string|min:50|max:5000',
            'fee' => 'nullable|max:99999999|min:0.50',
        ]);

        $jobOffer->update([
            'content' => $request->input('content'),
            'fee' => (int)($request->input('fee') * 100),
        ]);

        $jobOffer->location->update($request->all());

        return redirect(route('offers.index'))->with('message', 'Your offer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOffer $jobOffer)
    {
        $jobOffer->delete();
        return redirect(route('offers.index'))->with('message', 'Offer successfully deleted');
    }
}

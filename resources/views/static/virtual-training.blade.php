@extends('layouts.app')
@section('title', 'Virtual Soccer Training')
@section('content')
@section('description', 'Treiner is now offering online soccer coaching sessions. Stuck at home? Book a session with Treiner and keep your soccer skills sharp.')
<div class="row">
    <div class="col-sm-12 text-sm-left">
        <div class="row">
            <div class="col-sm-6 contact-bg">
            </div>
            <div class="col-sm-6">
                <h1 class="h3-large" style="margin-bottom:40px;">
                    <span>Virtual Training</span>
                </h1>

                <p>Treiner is now offering virtual soccer training sessions. If you find yourself stuck at home,
                    virtual training is the ideal way to keep yourself on your feet at home and your soccer skills
                    on point. Now, when you <a href="#" class="post-job">post a job</a> you can choose to run it
                    over Zoom and receive the same quality of coaching from local coaches from the comfort of your own
                    home. Additionally, you can find coaches that offer virtual training sessions that you can book with
                    other players.</p>
                <p>
                    Like all other sessions, virtual coaching can be done by yourself or within a group, and 
                    you will be able to support your local coaches by booking virtual training sessions with them.
                    Once the session is booked you'll be able to join it via Zoom through the Live Sessions tab in
                    your dashboard.
                </p>
                <p><a href="#" class="post-job">Post a virtual training job</a> or <a href="{{route('coaches.show-cities')}}">search for a coach</a> that offers virtual training!</p>
            </div>
        </div>
    </div>
</div>

@endsection

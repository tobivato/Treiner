@extends('dashboard.layouts.layout')
@section('title', 'Dashboard')
@section('content')
@section('sub-navbar')
@include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.messages')
@include('layouts.components.errors')
<div class="alert alert-info">
    <div class="row">
        <div class="col-sm-10">
            @if(!Auth::user()->coach->verified)
            <h3><i class="fas fa-question-circle fa-lg"></i> Before you can start adding new sessions you must do the
                following</h3>
            @else
            <h3><i class="fas fa-question-circle fa-lg"></i> About Your Account</h3>
            @endif
            <hr>
            @if(!Auth::user()->coach->verified)
            @if(Auth::user()->coach->verification_status == 'denied')
            <h4>Your application to join Treiner has been rejected. If you believe this is in error, please <a
                    href="{{route('contact')}}">contact us.</a></h4>
            @else
            <h4>You still need to: </h4>
            <ul>
                @if(!Auth::user()->coach->stripe_token)
                <li>Set up your <a href="{{Auth::user()->coach->stripe_link}}">payment details</a></li>
                @endif
                @if(!Auth::user()->email_verified_at)
                <li>Verify your email address</li>
                @endif
                @if(Auth::user()->coach->verification_status == 'pending')
                <li>Wait for us to check your documents (this may take a few days, we'll get back to you via email when
                    it's
                    done)</li>
                @endif
            </ul>
            @endif
            @else
            @if(count(Auth::user()->coach->sessions->where('status', 'scheduled')) == 0)
            <p>You don't have any sessions scheduled. Adding sessions means that you'll be able to be searched for and
                booked by
                players, so that you'll get bookings without needing to search for and apply to jobs. Create a session
                below.
            </p>
            @else
            <p>Sessions are very important for coaches, since they mean that players will be able to find your profile
                and book you
                immediately. You can use this page to set up, edit and delete your sessions.
            </p>
            @endif
            @endif
        </div>
    </div>
</div>
@if(Auth::user()->coach->verified)
<div class="text-right" style="margin-bottom:1vh;">
    <a name="add-session" id="add-session" class="btn btn-primary" href="#" data-toggle="modal"
        data-target="#session-modal" role="button">Add Session</a>
</div>
<style>
    td a {
        display:block;
    }
</style>
<div class="table-responsive table-hover">
    <table class="table">
        <thead>
            <tr>
                <th>Location</th>
                <th>Starts At</th>
                <th>Length (minutes)</th>
                <th>Price/hour ({{Auth::user()->currency}})</th>
                <th>Type</th>
                <th>Total revenue ({{Auth::user()->currency}})</th>
                <th>Booked</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(Auth::user()->coach->sessions->sortByDesc('starts') as $session)
            <tr>
                <td><a href={{route('sessions.show', $session)}}>{{$session->location->address}}</a></td>
                <td><a href={{route('sessions.show', $session)}}>{{$session->starts->format('H:i d/m/y')}}</a></td>
                <td><a href={{route('sessions.show', $session)}}>{{$session->length}}</a></td>
                <td><a href={{route('sessions.show', $session)}}>{{$session->formattedFee}}</a></td>
                <td><a href={{route('sessions.show', $session)}}>@lang('coaches.'.$session->type)</a></td>
                <td><a href={{route('sessions.show', $session)}}>{{$session->formattedTotalFee}}</a></td>
                <td><a href={{route('sessions.show', $session)}}>{{count($session->sessionPlayers)}} / {{$session->group_max}}</a></td>
                <td><a href={{route('sessions.show', $session)}}>{{ucfirst($session->status)}}</a></td>
                <td>
                    <div class="btn-group">
                        <button class="dropdown-toggle" type="button" id="{{$session->id}}-dropdown" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{$session->id}}-dropdown">
                            <a class="dropdown-item copyable" href="#" data-clipboard-text="{{route('book.store.url', $session)}}">Copy booking link</a>
                            <form action="{{route('sessions.destroy', $session)}}"
                            onsubmit="return confirm('Are you sure you want to cancel this session?')" method="POST">
                            @method('delete')
                            @csrf
                            <button type="submit" class="dropdown-item">Cancel</button>
                            </form>
                            @can('payout', $session)
                            <form action="{{route('sessions.payout', $session)}}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">Complete</button>
                            </form>
                            @endcan
                            <a class="dropdown-item" href="{{ route('reports.create-coach', $session->id)}}" role="button">Report an
                                Issue</a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<!-- Booking Modal -->
<div class="modal post-job-modal fade" id="session-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="msform" method="POST" action="{{route('sessions.store')}}">
                @csrf
                <fieldset class="fieldsetStep" data-name="session/create/players-number">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Create a session</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Minimum and maximum players
                                </h5>
                                <p class="text-center text-muted futura-medium mt-2">How many players do you want be
                                    able to book your session?</p>
                                <div class="alert alert-info">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <h3><i class="fas fa-question-circle fa-lg"></i> Notice</h3>
                                            <hr>
                                            <p>Due to the outbreak of COVID-19, Treiner is only accepting in-person
                                                sessions with
                                                one player. Virtual sessions may have as many players as you would like.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="group-min">Minimum</label>
                                    <input type="number" name="group_min" id="group-min" class="form-control" min="1"
                                        value="1" max="16" step="1"
                                        onchange="document.getElementById('group-max').min = this.value" required>
                                    <small class="text-muted">The minimum number of players for this session to
                                        run</small>
                                </div>
                                <div class="form-group">
                                    <label for="group-max">Maximum</label>
                                    <input type="number" name="group_max" id="group-max" class="form-control" value="1"
                                        min="1" max="16" step="1" required>
                                    <small class="text-muted">The maximum number of players that can be booked for this
                                        session</small>
                                </div>
                                <p class="text-center futura-medium mt-5">You can choose a minimum of one and a maximum
                                    of 16 players for your session.
                                    Consider pricing your sessions at a lower value with more players, since players
                                    find sessions with less players more valuable.
                                </p>
                            </div>
                        </div>
                    </div>
                    <button class="next action-button btn btn-primary btn-md" value="Next" id="title-next"
                        name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="session/create/session-type">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Session type</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Enter the type of training for this session.
                                </h5>
                                <p class="text-center text-muted futura-medium mt-2">You can only choose from your
                                    profile's session types.
                                    To add more session types to you account, go to <a
                                        href="{{route('home.profile')}}">your profile</a>.</p>
                                <div class="form-group">
                                    <select class="form-control" name="type" required>
                                        @foreach((Auth::user()->coach->session_types) as $type)
                                        <option value={{$type}}>@lang('coaches.' . $type)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" value="Next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="session/create/price">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Hourly Price</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Please enter the hourly price that you want
                                    to charge for this session.</h5>
                                <p class="text-center text-muted futura-medium mt-2">Ensure that you have a price that
                                    you think is fair to make sure you attract as many players as possible.</p>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text">{{config('money.' . Auth::user()->currency . '.symbol')}}</span>
                                        </div>
                                        <input type="number" class="form-control" step="0.01" value="0.50" min="0.5"
                                            name="fee" required aria-describedby="helpId">
                                    </div>
                                    <small id="helpId" class="form-text text-muted">Price per hour
                                        ({{Auth::user()->currency}})</small>
                                </div>
                                <div class="form-check">
                                  <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="cash-payments" id="cash-payments" value="true">
                                    Accept cash payments from players <i class="fas fa-question-circle" title="When players opt to use cash payments you will receive the full sum from them at the session in cash, and you won't be required to pay anything to Treiner."></i>
                                  </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" value="Next" id="details-next"
                        name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="session/create/length">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">How many minutes?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Choose your location.</h5>
                                <p class="text-center text-muted futura-medium mt-2">Enter a location in the search box
                                    below
                                    where you would like to host this session.</p>
                                @include('layouts.components.location-search')
                                <p class="text-center futura-medium mt-5">The location must be specific, and not a
                                    suburb or
                                    general area.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" value="Next" id="length-next"
                        name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="session/create/date">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">When would you like to run this session?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Choose when you would like the
                                    training to commence.</h5>
                                <p class="text-center text-muted futura-medium mt-2">Click the box below, and choose a
                                    date from the calendar within the next three months to begin training.</p>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="datetime-local" class="form-control" name="starts"
                                                value="{{Carbon\Carbon::now()->add('+6 hours')->format('Y-m-d\TH:i')}}"
                                                min="{{Carbon\Carbon::now()->add('+6 hours')->format('Y-m-d\TH:i')}}"
                                                max="{{Carbon\Carbon::now()->add(1, 'year')->format('Y-m-d\TH:i')}}"
                                                required>
                                            <small class="form-text text-muted">Starts at</small>
                                        </div>
                                        <p class="text-center text-muted futura-medium mt-2">You also need to choose how
                                            long
                                            you want this session to run for.</p>
                                        <div class="form-group">
                                            <select class="form-control" name="length" required>
                                                <option value=30>30 minutes</option>
                                                <option value=60>60 minutes</option>
                                                <option value=90>90 minutes</option>
                                                <option value=120>120 minutes</option>
                                                <option value=150>150 minutes</option>
                                                <option value=180>180 minutes</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-check">
                                                    <p class="text-center text-muted futura-medium mt-2">
                                                        <input type="checkbox" name="hourly_recurrence"
                                                            class="form-check-input" id="hourly-recurrence"
                                                            onchange="$('#hourly-recurring').toggle()">
                                                        <span onclick="$('#hourly-recurrence').click()">Will you be
                                                            available at this venue for more than one session?</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="hourly-recurring" style="display:none">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="hourly-recur-for"></label>
                                                    <input type="number" class="form-control" min="1" max="12"
                                                        name="hourly_recur_for" id="hourly-recur-for">
                                                    <small id="hourly-recur-help" class="form-text text-muted">How many
                                                        sessions?</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-check">
                                                    <p class="text-center text-muted futura-medium mt-2">
                                                        <input type="checkbox" name="recurring_change"
                                                            class="form-check-input" id="recurring-change"
                                                            onchange="$('#recurring').toggle()">
                                                        <span onclick="$('#recurring-change').click()">You can also have
                                                            the session repeat on specific days according to your
                                                            requirements.</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="recurring" style="display:none">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recur"></label>
                                                    <select class="form-control" name="recur" id="">
                                                        <option value="daily">Daily</option>
                                                        <option value="second-day">Every second day</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="fortnightly">Fortnightly</option>
                                                        <option value="monthly">Monthly</option>
                                                    </select>
                                                    <small class="form-text text-muted">Recur</small>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recur-for"></label>
                                                    <input type="number" class="form-control" min="1" max="9"
                                                        name="recur_for" id="recur-for" placeholder="">
                                                    <small id="recur-help" class="form-text text-muted">How many
                                                        times?</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-center futura-medium mt-5">Select a date and time above to commence
                                    training on.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" value="Next" id="date-next"
                        name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="session/create/finalise">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Add your session</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto text-center">
                                <img class="w-75" src="{{asset('img/post-job-finish.svg')}}" alt="Job post finished">
                                <h5 class="h3 futura-bold text-center mt-4">Your session is ready to post!</h5>
                                <p class="text-center futura-medium mt-2">Just click “Submit” below and your session
                                    will be
                                    posted for you and will be seen immediately by players. You can edit and make
                                    changes from the dashboard.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button type="submit" class="submit action-button btn btn-primary btn-md">Submit</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection

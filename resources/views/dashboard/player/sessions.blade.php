@extends('dashboard.layouts.layout')
@section('title', 'Sessions')
@section('content')
@section('sub-navbar')
@include('dashboard.layouts.navbar')
@endsection

@include('layouts.components.messages')

@if(count(Auth::user()->player->sessionPlayers->where('session.status', 'completed')->where('reviewed', false)) > 0)        
    @include('dashboard.player.reviews.review-modal')
@endif

<div class="alert alert-info">
    <div class="row">
        <div class="col-sm-10">
            <h3><i class="fas fa-question-circle fa-lg"></i> Sessions</h3>
            <hr>
            <p>From here you can see all the sessions that you've booked with coaches. You can also withdraw from them
                or report coaches from here.
            </p>
            @if(count(Auth::user()->player->sessionPlayers) == 0)
            <p>You don't currently have any sessions. <a href="{{route('coaches.welcome')}}">Book a coach</a> or <a
                    href="#" class="post-job">create a job</a> to get one.</p>
            @endif
        </div>
    </div>
</div>
<div class="container">
    <h2 class="futura-bold">Upcoming Sessions</h2>
    <div class="row equal">
        @foreach (Auth::user()->player->sessionPlayers->where('session.status', 'scheduled') as $sessionPlayer)
        <div class="col-lg-4 mb-3">
            <div class="card text-left">
                <img class="card-img-top"
                    src="{{Cloudder::secureShow($sessionPlayer->session->coach->user->image_id, ['height' => 300])}}"
                    alt="{{$sessionPlayer->session->coach->user->name}}">
                <div class="card-header">
                    <h3 class="futura-bold">@lang('coaches.'.$sessionPlayer->session->type) with
                        <a href="{{route('coaches.show', $sessionPlayer->session->coach)}}">{{$sessionPlayer->session->coach->user->name}}</a></h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-muted" style="padding-top: 10px;">
                                {{$sessionPlayer->session->formattedFeePerPerson}}</h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="dropdown open text-right">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <form action="{{route('sessions.withdraw', $sessionPlayer->id)}}"
                                        onsubmit="return confirm('Are you sure you want to withdraw from this session?')"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">Withdraw</button>
                                    </form>
                                    <a class="dropdown-item" href="{{route('reports.create-player', $sessionPlayer)}}"
                                        role="button">Report an Issue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-muted"><i class="fas fa-futbol"></i>
                                {{ucfirst($sessionPlayer->session->status)}}</h3>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-muted"><i class="fas fa-hourglass-half"></i>
                                {{$sessionPlayer->session->length}} minutes</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="text-muted" title="{{$sessionPlayer->session->starts}}"><i
                                    class="far fa-calendar-alt"></i>
                                {{$sessionPlayer->session->starts->format('l, jS \o\f F \a\t g:ia')}}</h3>
                        </div>
                        <div class="col-sm-12">
                            <h4 class="text-muted"><i class="fas fa-location-arrow"></i>
                                {{$sessionPlayer->session->location->address}}</h4>
                        </div>
                    </div>
                    <hr>
                    @if($sessionPlayer->session->type == 'VirtualTraining')
                      @if($sessionPlayer->session->zoom_number)
                          <a class="btn btn-primary btn-large text-right" style="width:100%;" href="{{route('live.show', $sessionPlayer->session->zoom_number)}}" role="button">Join Session</a>
                      @else
                          <h4>Please wait for the coach to create the meeting.</h4>
                      @endif
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<hr>
<div class="container">
    <h2 class="futura-bold">Completed Sessions</h2>
    <div class="row equal">
        @foreach (Auth::user()->player->sessionPlayers->where('session.status', 'completed') as $sessionPlayer)
        <div class="col-lg-4 mb-3">
            <div class="card text-left">
                <img class="card-img-top"
                    src="{{Cloudder::secureShow($sessionPlayer->session->coach->user->image_id, ['height' => 300])}}"
                    alt="{{$sessionPlayer->session->coach->user->name}}">
                <div class="card-header">
                    <h3 class="futura-bold">@lang('coaches.'.$sessionPlayer->session->type) with
                        <a href="{{route('coaches.show', $sessionPlayer->session->coach)}}">{{$sessionPlayer->session->coach->user->name}}</a></h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-muted" style="padding-top: 10px;">
                                {{$sessionPlayer->session->formattedFeePerPerson}}</h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="dropdown open text-right">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    @if(!$sessionPlayer->reviewed)
                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#review-modal">
                                        Add review
                                    </button>
                                    @else
                                    <a class="dropdown-item" href="{{route('reviews.edit', $sessionPlayer->review->id)}}"
                                    role="button">Edit review</a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('reports.create-player', $sessionPlayer)}}"
                                        role="button">Report an Issue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-muted"><i class="fas fa-futbol"></i>
                                {{ucfirst($sessionPlayer->session->status)}}</h3>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-muted"><i class="fas fa-hourglass-half"></i>
                                {{$sessionPlayer->session->length}} minutes</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="text-muted" title="{{$sessionPlayer->session->starts}}"><i
                                    class="far fa-calendar-alt"></i>
                                {{$sessionPlayer->session->starts->format('l, jS \o\f F \a\t g:ia')}}</h3>
                        </div>
                        <div class="col-sm-12">
                            <h4 class="text-muted"><i class="fas fa-location-arrow"></i>
                                {{$sessionPlayer->session->location->address}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

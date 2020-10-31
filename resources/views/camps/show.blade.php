@extends('layouts.app', ['background' => 'coach-background'])
@section('title', $camp->title)
@section('content')
@section('og-image', Cloudder::secureShow($camp->image_id, ['width' => '1200', 'height' => '630']))
<div class="row">
    <img src="{{Cloudder::secureShow($camp->image_id, ['width' => '1500', 'height' => '300'])}}" style="width:100%; padding:0;" alt="{{$camp->title}}">
</div>
<div class="row">
        <div class="mt-sm-4 mt-md-0" style="width:100%">
            <div class="card card-body profile-rate-sec">
                <div class="media">
                    <div class="media-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <h2 class="futura-bold mb-1">{{$camp->title}}</h2>
                            </div>
                            <div class="col-lg-3">
                                <h3 class="text-lg text-muted">
                                    <i class="fas fa-coins"></i>
                                    {{$camp->session->formattedFeePerPerson}}
                                    <div class="text-right">
                                        <i class="fas fa-user-friends mr-2"></i>{{($camp->session->playersCount)}} / {{$camp->session->group_max}}
                                    </div>
                                </h3>
                                <p class="text-muted mb-0" title="{{$camp->session->starts}}">
                                    <i class="far fa-calendar-alt mr-2"></i>{{$camp->session->starts->format('d/m/Y')}} - {{$camp->session->starts->addDays($camp->days)->format('d/m/Y')}}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clock mr-2"></i>{{\Carbon\Carbon::createFromFormat('H:i:s', $camp->start_time)->format('h:i a') . ' - ' . \Carbon\Carbon::createFromFormat('H:i:s', $camp->end_time)->format('h:i a')}}
                                </p>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-4">
                                <a class="profile-location" data-toggle="modal" data-target="#map" href="">
                                    <i class="fas fa-map-marker-alt"></i> {{$camp->session->location->address}}
                                    <br />
                                    <span class="text-muted mb-0">View Location</span>
                                </a>
                                <p class="text-muted">
                                    <i class="fas fa-calendar"></i>
                                    {{$camp->formattedAges}}
                                </p>
                            </div>
                        </div>
                    </div>
                    @auth
                    <div class="media-right">
                        <button type="button" style="
						padding: 6px 35px;" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#camp-modal">
                            Book Camp
                        </button>
                    </div>
                    @else
                    <div class="media-right">
                        <a href="{{route('login')}}" style="
						padding: 6px 35px;" class="btn btn-primary btn-lg btn-block">                            Book Camp
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
            <div class="card card-body">
                <div class="row">
                    <div class="col-sm-7">
                        <h2 class="bordered-title futura-bold"><span>About Camp</span></h2>
                        <div class="tabs-sec mb-3">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#details">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tos">Terms of Service</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="details" class="tab-pane active">
                                    <p class="regular-size mb-0">{!!nl2br(e($camp->description))!!}</p>
                                </div>
                                <div id="tos" class="tab-pane fade">
                                    <p class="regular-size mb-0">{!!nl2br(e($camp->tos))!!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <h2 class="bordered-title futura-bold"><span>Coaches</span></h2>
                        @foreach($invitations as $invitation)
                            @include('coach.search-component', ['coach' => $invitation->coach])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Booking Modal -->
<div class="modal post-job-modal fade" id="camp-modal" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="msform" method="POST" action="{{route('book.store')}}">
				@csrf
				<input type="hidden" name="session_id" id="session-id" value="{{$camp->session->id}}">
                <fieldset class="fieldsetStep" data-name="camps/{{$camp->id}}/book/players-number">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">How many athletes?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">How many players are you booking this camp for?
                                </h5>
                                <p class="text-center text-muted futura-medium mt-2">Tell us how many athletes you are booking 
									this camp for. You can book for yourself or other people as well.
								</p>
                                <div class="form-group">
                                <input type="number" required pattern="[0-9]*" max="{{$camp->session->group_max - ($camp->session->playersCount)}}" min="1" id="athletes" name="number" class="form-control form-control-lg futura-bold text-dark h2 text-center d-inline mb-0"
                                        data-next="number-next">
                                        <small class="form-text text-right mt-2 text-muted">Athletes</small>
								</div>
                                <p class="text-center futura-medium mt-5">Enter the number of players that you are booking the camp
									on behalf of. If you're only booking for yourself, just enter "1".</p>
                            </div>
                        </div>
					</div>
					<button type="submit" id="number-next" disabled class="submit action-button btn btn-primary btn-md">Go to payment</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

@include('layouts.components.map', ['locations' => collect([$camp->session->location])])
@endsection
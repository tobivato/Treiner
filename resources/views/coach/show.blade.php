@extends('layouts.app', ['background' => 'coach-background'])
@section('title', $coach->user->name)
@section('content')
@section('og-image', Cloudder::secureShow($coach->user->image_id, ['width' => '1200', 'height' => '630']))
@section('description', 'Book soccer coaching sessions with ' . $coach->user->name . ' on Treiner. ' . Str::limit($coach->profile_summary, 120, '...'))
@section('schema')
	@include('schema.coach')
@endsection
@include('layouts.components.messages')
		<div class="row equal">
			<div class="col-lg-3 col-md-4" style="padding-bottom: 20px">
				<div class="card card-body profile-sidebar">
					<div class="profile-img">
						<img class="rounded-circle" src="{{Cloudder::secureShow($coach->user->image_id)}}" alt="{{$coach->user->name}}">
					</div>
					<h1 class="futura-bold text-center mt-3 mb-2 profile-name">{{$coach->user->name}} @include('layouts.components.coaches.badge')</h1>
					@if($coach->fee)<p class="text-center"><span class="regular-size futura-medium">{{$coach->fee ? "$".$coach->fee." per hour": ""}} <span class="text-muted"></span></span></p>@endif
					<table class="table">
						<tbody>
							<tr>
								<td class="w-50 futura-medium">
									Highest Qualification
								</td>
								<td class="w-50 text-right">
									@lang('coaches.' . $coach->qualification)
								</td>
							</tr>
							<tr>
								<td class="w-50 futura-medium">
									Years Coaching
								</td>
								<td class="w-50 text-right">
									{{$coach->years_coaching}}
								</td>
							</tr>
							<tr>
								<td class="w-50 futura-medium">
									Age Groups Coached
								</td>
								<td class="w-50 text-right">
									{{$coach->formattedAgeGroupsCoached}}
								</td>
							</tr>
							<tr>
								<td class="w-50 futura-medium">
									Checked & Approved
								</td>
								<td class="w-50 text-right">
									@if($coach->verified)
									<i class="fas fa-check-circle text-primary fa-2x"></i>
									@else
									<i class="fas fa-cross-circle text-primary fa-2x"></i>
									@endif
								</td>
							</tr>
						</tbody>
					</table>
					@if($coach->availabilities->count() != 0)
					<button type="button" class="btn btn-primary btn-lg btn-block btn-profile" data-toggle="modal" onclick="productListViewed()" title="See what sessions this coach has available" data-target="#booking-modal">
						Book Session
					</button>
					@endif
					<a href="#" title="Request a session in a time and place that suits you" class="btn btn-primary btn-lg btn-block btn-profile request-session" data-coach-id="{{$coach->id}}">Request a Session</a>

					<div class="job-share-icons mt-4" style="text-align:center;">
						<ul class="list-inline py-3 mb-0">
							<li class="list-inline-item bg-transparent border-0 p-0 mb-2">
								<a target="_blank" rel="noopener" href="https://www.facebook.com/share.php?u={{$link}}&title={{$title}}"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
							</li>
							<li class="list-inline-item bg-transparent border-0 p-0 mb-2">
								<a target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?status={{$title}}+{{$link}}"><i class="fab fa-twitter-square" aria-hidden="true"></i></a>
							</li>
							<li class="list-inline-item bg-transparent border-0 p-0 mb-2">
								<a target="_blank" rel="noopener" href="https://www.linkedin.com/shareArticle?mini=true&url={{$link}}&title={{$title}}&source=Treiner"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
							</li>
							<li class="list-inline-item bg-transparent border-0 p-0 mb-2 copyable" data-clipboard-text="{{route('coaches.show', $coach)}}">
								<a href="#"><i class="far fa-copy" aria-hidden="true"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="mt-sm-4 mt-md-0 scroll-sec active-scroll">
					<div class="card card-body profile-rate-sec">
						<div class="media">
							<div class="media-body">
								<div class="row">
									<div class="col-lg-4">
										<h2 class="futura-bold mb-1">{{$coach->user->name}} @include('layouts.components.coaches.badge')</h2>
										<p class="text-muted mb-0" title="{{$coach->user->created_at}}">Joined Treiner {{$coach->user->created_at->diffForHumans()}}</p>
									</div>
									<div class="col-lg-4">
										<div class="rate-stars text-primary" title="{{$coach->averageReview}}">
                      					@include('layouts.components.coaches.stars')
                   						 </div>
										<p class="text-muted mb-0">based on {{count($coach->reviews)}} reviews</p>
									</div>
									<div class="col-lg-4">
										@if($coach->formattedLocations)
										<a class="profile-location" data-toggle="modal" data-target="#map" href="">
											<i class="fas fa-map-marker-alt"></i> {{$coach->formattedLocations}}
											<br />
											<span class="text-muted mb-0">View Training Locations</span>
										</a>
										@else
										<a class="profile-location" data-toggle="modal" data-target="#map" href="">
											<i class="fas fa-map-marker-alt"></i> {{$coach->location->address}}
											<br />
										</a>
										@endif
									</div>
								</div>
							</div>
							<div class="media-right">
								@auth
								@if ($coach->availabilities->count() == 0)
								<div class="media-right">
									<a href="#" title="Request a session in a time and place that suits you" class="btn btn-primary btn-lg btn-block btn-profile request-session" data-coach-id="{{$coach->id}}">Request a Session</a>
								</div>
								@else
								<div class="media-right">
									<button type="button" style="
									padding: 6px 35px;" class="btn btn-primary btn-lg btn-block" onclick="productListViewed()" data-toggle="modal" data-target="#booking-modal">
										Book Session
									</button>
								</div>
								@endif
								@else
								<div class="media-right">
									<a href="{{route('login')}}" style="
									padding: 6px 35px;" class="btn btn-primary btn-lg btn-block">Book Session
									</a>
								</div>
								@endauth
							</div>
						</div>
					</div>

					<div class="card card-body">
						<h2 class="bordered-title futura-bold"><span>Summary</span></h2>
						<p class="regular-size">{!!nl2br(e($coach->profile_summary))!!}</p>

						<h2 class="bordered-title futura-bold"><span>Session Types</span></h2>
						<div class="type-btns mb-4">
							@foreach (($coach->session_types) as $session_type)
							<a class="btn btn-sm btn-default ml-2">@lang('coaches.'.$session_type)</a>
							@endforeach
						</div>

						<h2 class="bordered-title futura-bold"><span>About Coach</span></h2>
						<div class="tabs-sec mb-3">
							<!-- Nav tabs -->
							  <ul class="nav nav-tabs">
							    <li class="nav-item">
							      <a class="nav-link active" data-toggle="tab" href="#philosophy">Coaching Philosophy</a>
							    </li>
							    <li class="nav-item">
							      <a class="nav-link" data-toggle="tab" href="#playing">Playing and Coaching Career</a>
							    </li>
							    <li class="nav-item">
							      <a class="nav-link" data-toggle="tab" href="#average">Average Session</a>
							    </li>
							  </ul>

							  <!-- Tab panes -->
							  <div class="tab-content">
							    <div id="philosophy" class="tab-pane active">
							      <p class="regular-size mb-0">{!!nl2br(e($coach->profile_philosophy))!!}</p>
							    </div>
							    <div id="playing" class="tab-pane fade">
							      <p class="regular-size mb-0">{!!nl2br(e($coach->profile_playing))!!}</p>
							    </div>
							    <div id="average" class="tab-pane fade">
							      <p class="regular-size mb-0">{!!nl2br(e($coach->profile_session))!!}</p>
							    </div>
							  </div>
						</div>

            @if($coach->reviews->count() > 0)
				<h2 class="bordered-title futura-bold"><span>Reviews</span></h2>
            @foreach($coach->reviews as $review)
						<div class="review-list mb-3">
							<div class="review-item">
								<div class="media">
									<div class="media-left">
										<img class="review-img rounded-circle" src="{{Cloudder::secureShow($review->sessionPlayer->player->user->image_id)}}" alt="{{$review->sessionPlayer->player->user->name}}">
									</div>
									<div class="media-body pl-3">
										<div class="rate-stars text-primary mb-1" title="{{$review->rating}}">
											@include('layouts.components.coaches.stars')										</div>
										<p class="text-muted mb-0" title="{{$review->create_at}}">{{$review->created_at->diffForHumans()}} by {{$review->sessionPlayer->player->user->name}}</p>
										<h3 class="futura-medium">@lang('coaches.' . $review->sessionPlayer->session->type)</h3>
									</div>
								</div>
								<p class="regular-size mt-2 mb-0">{{$review->content}}</p>
							</div>
						</div>
              @endforeach

              @endif
            </div>
					</div>
				</div>
			</div>
		</div>

<!-- Booking Modal -->
<div class="modal post-job-modal fade" id="booking-modal" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="msform" method="POST" action="{{route('book.store')}}">
				@csrf
				<input type="hidden" name="session_id" id="session-id" value="">
                <fieldset class="fieldsetStep fieldsetStep-xlWidth" data-name="coaches/{{$coach->id}}/book/choose-session">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Book a session</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-md-11 m-auto">
								<table class="table">
									<thead>
										<tr>
											<th>Starts</th>
											<th>Type</th>
											<th>Length</th>
											<th>Price ({{$coach->user->currency}})</th>
											<th>Location</th>
											<th>Bookings</th>
											<th>Max Players</th>
											<th>Book</th>
										</tr>
									</thead>
									<tbody class="futura-bold">
										@foreach ($coach->availabilities as $availability)
											<tr>
												<td title="{{$availability->starts}}">{{$availability->starts->format('D d/m/y g:ia')}}</td>
												<td>@lang('coaches.'.$availability->type)</td>
												<td>{{$availability->length}}</td>
												<td>{{$availability->formattedFee}}</td>
												<td>{{$availability->location->street_address . ' ' . $availability->location->locality}}</td>
												<td>{{$availability->playersCount}}</td>
												<td>{{$availability->group_max}}</td>
												<td><button class="next action-button btn btn-primary btn-md" value="Next" data-max-players="{{$availability->group_max - $availability->playersCount}}" data-session="{{$availability->id}}" onclick="$('#session-id').val($(this).data('session')); $('#athletes').attr('max', $(this).data('max-players'))" name="next">Book</button>												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
                        </div>
					</div>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="coaches/{{$coach->id}}/book/players-number">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">How many athletes?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">How many players are you booking this session for?
                                </h5>
                                <p class="text-center text-muted futura-medium mt-2">Tell us how many athletes you are booking
									this session for. You can book for yourself or other people as well.
								</p>
                                <div class="form-group">
                                    <input type="number" required pattern="[0-9]*" max="" min="1" id="athletes" name="number" class="form-control form-control-lg futura-bold text-dark h2 text-center d-inline mb-0"
                                        data-next="number-next">
                                        <small class="form-text text-right mt-2 text-muted">Athletes</small>
								</div>
                                <p class="text-center futura-medium mt-5">Enter the number of players that you are booking the session
									on behalf of. If you're only booking for yourself, just enter "1".</p>
                            </div>
                        </div>
					</div>
					<button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
					<button type="submit" id="number-next" disabled class="submit action-button btn btn-primary btn-md">Go to payment</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script>
	function productListViewed() {
		analytics.track('Product List Viewed', {
			list_id: 'coach_{{$coach->id}}_sessions',
			category: 'Sessions',
			products: [
				@foreach ($coach->availabilities as $session)
				{
					product_id: '{{$session->id}}',
					name: '@lang('coaches.'.$session->type) in {{$session->location->locality}}',
					price: {{$session->fee / 100}},
					position: {{$loop->index}},
					category: 'Sessions',
					url: '{{route('book.store.url', $session)}}',
				},
				@endforeach
			]
		});
	}
</script>

@include('layouts.components.map', ['locations' => $coach->locations])
@endsection

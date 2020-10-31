@extends('layouts.app')
@section('title', $jobPost->title)
@section('content')
@section('sub-navbar')
    @include('jobs.search-navbar')
@endsection
<div class="row no-gutters">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
        <div class="mt-sm-4 mt-md-0 pl-2 pr-4">
            <div class="row">
                <div class="col-lg-7">
                    <h2 class="futura-bold"><u>{{$jobPost->title}}</u></h2>
                    <ul class="list-unstyled user-info-panel">
                        <li>
                            <div class="media align-items-center border-bottom border-dark py-3">
                                <img src="{{Cloudder::secureShow($jobPost->player->user->image_id)}}" width="75" class="mr-3 review-img rounded-circle" alt="{{$jobPost->player->user->name}}">
                                <div class="media-body">
                                    <div class="row no-gutters">
                                        <div class="col-lg-9">
                                            <p class="text-muted mb-1">Posted by</p>
                                            <h2 class="h4 futura-medium mb-0">{{$jobPost->player->user->name}}</h2>
                                        </div>
                                        <div class="col-lg-3 align-self-end">
                                            <p class="small text-muted mb-0 text-md-right" title="{{$jobPost->created_at}}">{{$jobPost->created_at->diffForHumans()}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media align-items-center border-bottom border-dark py-3">
                                <div class="media-left text-center">
                                    <i class="fas fa-map-marker-alt fa-3x mr-3 text-primary"></i>
                                </div>
                                <div class="media-body">
                                    <div class="row no-gutters">
                                        <div class="col-lg-9">
                                            <p class="text-muted mb-1">Location</p>
                                            <h2 class="h4 futura-medium mb-0">{{$jobPost->location->locality}}</h2>
                                        </div>
                                        <div class="col-lg-3 align-self-end">
                                            <a href="#" data-toggle="modal" data-target="#map" class="small mb-0 d-block text-md-right"><u>View map</u></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media align-items-center border-bottom border-dark py-3">
                                <div class="media-left text-center">
                                    <i class="far fa-calendar-alt fa-3x mr-3 text-primary"></i>
                                </div>
                                <div class="media-body">
                                    <div class="row no-gutters">
                                        <div class="col-lg-9">
                                            <p class="text-muted mb-1">Date</p>
                                            <h2 class="h4 futura-medium mb-0" title="{{$jobPost->starts}}">{{$jobPost->starts->format('g:ia D, jS F Y')}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
                <div class="col-lg-5 text-center">
                    <p class="h4 mb-0">Job Budget</p>
                    <h2 class="h1 futura-bold text-center mt-2 mb-0 job-price">{{$jobPost->formattedFee}}</h2>
                    <span class="text-muted d-block">Per hour</span>
                    @if(Auth::check() && Auth::user()->role instanceof Treiner\Coach)
                    <a class="btn btn-primary btn-lg py-2 px-4 mt-3" class="btn btn-primary" href="{{ route('offers.create', $jobPost->id) }}">Make Offer</a>
                    <div class="job-share-icons mt-4">
                        <p>
                            <i class="fa fa-flag bg-transparent border-0 p-0 mb-2" aria-hidden="true"></i>
                            <a href="{{route('support')}}"><span class="text-muted pl-2">Report this job</span></a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="job-details">
                <p class="text-muted mb-2">Details</p>
                <p class="regular-size">{!!nl2br(e($jobPost->details))!!}</p>
            </div>
            
            <div class="job-comment-box">
                @include('layouts.components.comments', ['name' => $jobPost->player->user->first_name, 'instance' => $jobPost, 'commentableType' => 'job'])
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>

@include('layouts.components.map', ['locations' => collect([$jobPost->location])])
@endsection
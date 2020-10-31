@extends('dashboard.layouts.layout')
@section('title', 'My Job Posts')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.messages')
@include('layouts.components.errors')
<div class="alert alert-info">
    <div class="row">
        <div class="col-sm-10">
            <h3><i class="fas fa-question-circle fa-lg"></i> Job Posts</h3>
            <hr>
            <p>Job posts let you choose your own type of training that you want to receive, and then
                let you choose from all coaches which apply to the job.
            </p>
            @if(count(Auth::user()->player->jobPosts) == 0)
            <p>You don't currently have any job posts. <a href="#" class="post-job">Click here</a> to create a job.</p>
          @endif
        </div>
    </div>
  </div>
@foreach ($jobPosts as $jobPost)
<div class="row">
    <h2 class="futura-bold mb-1"><a href="{{route('jobs.show', $jobPost)}}">{{$jobPost->title}}</a></h2>
</div>
<div class="row">
    <div class="col-sm-9">
        <div class="row">
            <div class="col-lg-4">
                <h4 class="text-muted"><i class="fas fa-futbol"></i> @lang('coaches.'.$jobPost->type)</h3>
            </div>
            <div class="col-lg-3">
                <h4 class="text-muted" title="{{$jobPost->starts}}"><i class="far fa-calendar-alt"></i> {{$jobPost->starts->format('d/m/Y h:ia')}}</h3>
            </div>
            <div class="col-lg-3">
                <h4 class="text-muted"><i class="fas fa-hourglass-half"></i> {{$jobPost->length}} minutes</h3>
            </div>
            <div class="col-lg-2">
                <h4 class="text-muted">{{$jobPost->formattedFee}}</h3>
            </div>
        </div>
        <div class="row">
            <h4 class="pl-3 text-muted">{{$jobPost->location->address}}</h4>
        </div>
    </div>
    <div class="col-sm-3">
        <form action="{{route('jobs.destroy', $jobPost->id)}}" onsubmit="return confirm('Are you sure you want to delete this job post?')" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-block">Delete</button>
        </form>
        <a class="btn btn-block" href="{{route('jobs.edit', $jobPost->id)}}" role="button">Edit</a>
    </div>
</div>
<div class="row">
        <div class="col-lg-5">
            <h3>Applications ({{count($jobPost->pendingJobOffers())}})</h3>
            <hr>
            @foreach ($jobPost->pendingJobOffers() as $jobOffer)
                <div class="row">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="{{Cloudder::secureShow($jobOffer->coach->user->image_id)}}" class="img-fluid rounded-circle" alt="{{$jobOffer->coach->user->name}}">
                        </div>
                        <div class="col-sm-6">
                                <p class="text-muted"><a target="_blank" rel="noopener" href="{{route('coaches.show', $jobOffer->coach)}}">{{$jobOffer->coach->user->name}}</a></p>
                                <p> @include('layouts.components.coaches.stars', ['coach' => $jobOffer->coach]) ({{count($jobOffer->coach->reviews)}})</p>
                                <p>{{$jobOffer->formattedFee}}</p>
                                <p>{{$jobOffer->location->address}}</p>
                        </div>
                        <div class="col-sm-3">
                            <a class="btn btn-block btn-success" href="{{route('offers.billing', $jobOffer->id)}}" role="button"><i class="fa fa-check" aria-hidden="true"></i></a>
                            <form action="{{route('offers.deny', $jobOffer->id)}}" method="post">
                                @csrf
                                <input type="hidden" name="status" value="declined">
                                <button class="btn btn-block btn-danger" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <p>{{$jobOffer->content}}</p>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6">
            <h3>Details</h3>
            <hr>
            <p>{{$jobPost->details}}</p>
        </div>
</div>
<hr>
@endforeach
@endsection
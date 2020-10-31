@extends('layouts.app')
@section('title', 'Apply for a job')
@section('content')
<form action="{{route('offers.store')}}" class="form" method="post">
    @include('layouts.components.errors')
    @csrf
    <input type="hidden" name="job_post_id" value="{{$jobPost->id}}">
    <div class="form-group">
      <label for="content">Why do you think you are suitable for this job?</label>
      <textarea class="form-control" name="content" id="content" minlength="50" rows="3">{{old('content')}}</textarea>
    </div>
    <p>The job is located at {{$jobPost->location->address}}, so enter a sporting facility or other location near there that you wish to use.</p>
    @include('layouts.components.location-search')
    <div class="form-group">
            <label for="">Your hourly price (the player recommends {{$jobPost->formattedFee}})</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
              <span class="input-group-text">{{config('money.' . Auth::user()->currency . '.symbol')}}</span>
              </div>
              <input type="number"
                  class="form-control" step="0.01" value="0.50" min="0.5" name="fee" value="{{old('fee')}}" aria-describedby="helpId" placeholder="">
            </div>
            <small id="helpId" class="form-text text-muted">Price per hour ({{Auth::user()->currency}})</small>
          </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
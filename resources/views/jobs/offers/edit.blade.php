@extends('layouts.app')
@section('title', 'Edit your applications')
@section('content')
<form action="{{route('offers.update', $jobOffer->id)}}" class="form" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="content">Why do you think you are suitable for this job?</label>
          <textarea class="form-control" name="content" minlength="50" id="content" rows="3">{{$jobOffer->content}}</textarea>
        </div>
        @include('layouts.components.location-search')
        <div class="form-group">
                <label for="">Your Price (Hour)</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                  <span class="input-group-text">{{config('money.' . Auth::user()->currency . '.symbol')}}</span>
                  </div>
                  <input type="number"
                      class="form-control" step="0.01" min="0.5" name="fee"  aria-describedby="helpId" value="{{$jobOffer->fee / 100}}" placeholder="">
                </div>
                <small id="helpId" class="form-text text-muted">Price per hour ({{Auth::user()->currency}})</small>
              </div>
    
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
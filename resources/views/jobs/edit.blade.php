@extends('layouts.app')
@section('title', 'Edit your posting')
@section('content')
<form class="form" action="{{route('jobs.update', $jobPost->id)}}" method="post">
        @method('PATCH')
        @csrf
        @include('layouts.components.errors')

        <input type="hidden" name="latitude" value="{{$jobPost->location->latitude}}">
        <input type="hidden" name="longitude" value="{{$jobPost->location->longitude}}">
        <input type="hidden" name="locality" value="{{$jobPost->location->locality}}">
        <input type="hidden" name="country" value="{{$jobPost->location->country}}">

        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" name="title" id="title" maxlength="32" class="form-control" value="{{$jobPost->title}}" required>
        </div>
    
        <div class="form-group">
            <label for="">Starts</label>
            <input type="datetime-local" class="form-control" name="starts" 
                value="{{$jobPost->starts->format('Y-m-d\TH:i')}}" min="{{Carbon\Carbon::now()->format('Y-m-d\TH:i')}}"
                max="{{Carbon\Carbon::now()->add('+3 months')->format('Y-m-d\TH:i')}}" aria-describedby="helpId"
                placeholder="">
            <small id="helpId" class="form-text text-muted">Starts at</small>
        </div>
    
        <div class="form-group">
            <label for="">Length</label>
            <select class="form-control" name="length" required>
                @foreach ([30, 60, 90, 120, 150, 180] as $time)
                    @if($jobPost->length == $time)
                        <option value="{{$time}}" selected>{{$time}} minutes</option>
                    @else
                        <option value="{{$time}}">{{$time}} minutes</option>
                    @endif
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="details">Details</label>
            <textarea class="form-control" name="details" data-length-indicator="length-indicator" id="details" maxlength="1500" rows="5" required>{{old('details') ? old('details') : $jobPost->details}}</textarea>
            <small class="text-muted d-block pt-2"><span id="length-indicator">1500</span> characters left</small>
        </div>
    
        <div class="form-group">
            <label for="">Session Type</label>
            <select class="form-control" name="type" >
                @foreach(config('treiner.sessions') as $type)
                    @if($jobPost->type == $type)
                        <option value={{$type}} selected>@lang('coaches.' . $type)</option>
                    @else
                        <option value={{$type}}>@lang('coaches.' . $type)</option>
                    @endif
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="">Budget (Hour)</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">{{config('money.' . Auth::user()->currency . '.symbol')}}</span>
                </div>
                <input type="number" class="form-control" value="{{$jobPost->fee / 100}}" step="0.01" value="0.50" min="0.5" required max="25000" name="fee" 
                    aria-describedby="helpId" placeholder="">
            </div>
            <small id="helpId" class="form-text text-muted">Price per hour ({{Auth::user()->currency}})</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
@endsection
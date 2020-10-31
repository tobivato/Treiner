@extends('dashboard.layouts.layout')
@section('title', 'Edit review')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.messages')
<form action="{{route('reviews.update', $review)}}" method="post">
    @method('PATCH')
    @csrf
    @include('layouts.components.messages')    
    @include('layouts.components.errors')
    <input type="hidden" name="session_id" value="{{$review->sessionPlayer->session->id}}">
    <div class="form-group">
        <label for="">Rating</label>
        <input type="number" class="form-control" max="100" min="0" step="1" name="rating" value="{{$review->rating}}" required>
        <small class="form-text text-muted">Rating (out of 100)</small>
    </div>
    <div class="form-group">
        <label for="review">Review</label>
        <textarea class="form-control" data-length-indicator="length-indicator" maxlength="5000" name="content" id="review" rows="3">{{$review->content}}</textarea>
        <small class="form-text text-right mt-2 text-muted"><span id="length-indicator">5000</span> characters remaining</small>
    </div>
    <button type="submit" class="btn btn-block btn-primary">Review</button>
</form>
@endsection
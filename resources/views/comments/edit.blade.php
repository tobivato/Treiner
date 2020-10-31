@extends('layouts.app')
@section('title', 'Edit your comment')
@section('content')
<form action="{{route('comments.update', $comment)}}" method="post">
    @method('PATCH')
    @csrf
    @include('layouts.components.errors')
    <div class="form-group">
        <label for="content">Your comment</label>
        <textarea class="form-control" name="content" required data-length-indicator="length-indicator" maxlength="5000" id="content" rows="3">{{$comment->content}}</textarea>
        <small class="form-text text-right mt-2 text-muted"><span id="length-indicator">5000</span> characters remaining</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
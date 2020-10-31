@extends('layouts.app')
@section('title', 'Edit your blog post')
@section('content')
    <h1>Edit Blog Entry</h1>
    <form action="{{ route('blogs.destroy' , $blog->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?')" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
    </form>        
    <form action="{{route('blogs.update', $blog->id)}}" enctype="multipart/form-data" method="post">
        {{ method_field('PATCH') }}
        @include('layouts.components.errors')
        @csrf
        <div class="form-group">
          <label for="">Title</label>
          <input type="text"
            class="form-control" name="title"  value="{{$blog->title}}" aria-describedby="helpId" placeholder="">
        </div>
        <div class="form-group">
                <label for="">Add an image</label>
                <input type="file" class="form-control-file" name="image"aria-describedby="fileHelpId">
                <small id="fileHelpId" class="form-text text-muted">Add an image for your blog here</small>
              </div>
              <div class="form-group">
                <label for="">Excerpt</label>
                <textarea class="form-control" name="excerpt" rows="3">{{$blog->excerpt}}</textarea>
              </div>      
        <div class="form-group">
          <label for="">Content</label>
          <textarea class="form-control" style="height:500px" name="content"  rows="3">{{$blog->content}}</textarea>
          <small id="helpId" class="form-text text-muted">Treiner blogs use Markdown</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>      
    <hr>
@endsection
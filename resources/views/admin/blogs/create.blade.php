@extends('admin.layouts.layout')
@section('title', 'Blog Posts')
@section('content')
<form action="{{route('blogs.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('layouts.components.errors')
    <div class="form-group">
      <input type="text"
        class="form-control" name="title" required maxlength="110" minlength="10" placeholder="Title">
    </div>
        <div class="form-group custom-file">
            <input type="file" name="image" id="image" required placeholder="Add an image for your blog" class="custom-file-input">
            <label for="image" class="custom-file-label">Add an image for your blog</label>
        </div>
    <div class="form-group">
        <label for="excerpt" style="padding-top:15px;">Excerpt</label>
        <textarea class="form-control" name="excerpt" rows="3" minlength="20" required></textarea>
    </div>      
    <div class="form-group">
      <label for="content">Content</label>
      <textarea class="form-control" name="content" required rows="10"></textarea>
      <small id="helpId" class="form-text text-muted">Treiner blogs use <a target="_blank" rel="noopener" href="https://www.markdownguide.org/cheat-sheet/">Markdown</a></small>
    </div>
    <button type="submit" class="btn btn-block btn-primary">Submit</button>
</form>   
@endsection 
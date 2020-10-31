@extends('dashboard.layouts.layout')
@section('title', 'Blogs')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@can('create', 'Treiner\BlogPost')
<div class="alert alert-info">
    <div class="row">
        <div class="col-sm-10">
            <h3><i class="fas fa-question-circle fa-lg"></i> Blog Posts</h3>
            <hr>
            <p>Blogs are a great way to boost your personal portfolio. By writing a blog post, you let players
            know how much you know about the game, and they're great for being seen by people randomly, which
            leads them to your coach profile and allows you to get more sessions booked. To create a blog post
            all you need to do is:</p>
            <ul>
                <li>Fill out the title</li>
                <li>Choose an image which you think would suit the post</li>
                <li>Write a short excerpt to draw the reader in</li>
                <li>Fill out the content of the post</li>
            </ul>
            <p>Then hit submit and anyone will be able to see your post from <a href="{{route('blogs.index')}}">
            the blogs page</a>.</p>
            <p>You can write blog posts about any subject you'd like that's related to soccer.</p>
        </div>
    </div>
</div>
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
<hr>
@endcan

@if(Auth::user()->coach->blogposts)
<div class="row">
        @foreach (Auth::user()->coach->blogposts as $blog)
        <div class="col-sm-6">
            @include('blogs.component')
        </div>
        @endforeach
    </div>
    @else
        <p>You currently don't have any blogs.</p>
    @endif
@endsection
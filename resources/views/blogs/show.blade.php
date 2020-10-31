@extends('layouts.app')
@section('title', $blog->title)
@section('content')
@section('og-image', Cloudder::secureShow($blog->image_id, ['width' => '1200', 'height' => '630']))
@section('description', $blog->excerpt)
@section('schema')
	@include('schema.blog')
@endsection
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">

        <h1 class="mt-4 futura-bold">{{ucfirst($blog->title)}}</h1>
        <h3 class="lead"><i>{{$blog->excerpt}}</i></h3>

        <p class="lead">
            by
            @if($blog->coach)
            <a href="{{route('coaches.show', ['coach' => $blog->coach->id, 'slug' => $blog->coach->slug])}}">{{$blog->coach->user->name}}</a>
            @else
            Treiner
            @endif
            @if(Auth::check() && Auth::user()->can('update', $blog))
            <a class="btn btn-primary text-right" href="{{route('blogs.edit', $blog->id)}}" role="button">Edit</a>
            @endif
        </p>
        <hr>

        <div class="row">
            <div class="col-sm-6">
                <p>Posted <span title="{{$blog->created_at}}">{{$blog->created_at->diffForHumans()}}</span></p>
            </div>
            <div class="col-sm-6">
                <div class="job-share-icons text-right">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2">
                            <a target="_blank" rel="noopener" href="https://www.facebook.com/share.php?u={{$link}}&title={{$title}}"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2">
                            <a target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?status={{$title}}+{{$link}}"><i class="fab fa-twitter-square" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2">
                            <a target="_blank" rel="noopener" href="https://www.linkedin.com/shareArticle?mini=true&url={{$link}}&title={{$title}}&source=Treiner"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2 copyable" data-clipboard-text="{{route('blogs.show', $blog)}}">
                            <a href="#"><i class="far fa-copy" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <img class="img-fluid rounded" alt="{{$blog->title}}" src="{{Cloudder::secureShow($blog->image_id, ['width' => 900, 'height' => 300])}}">
        <hr>
        @parsedown($blog->content)

        <hr>
    </div>
</div>
@endsection

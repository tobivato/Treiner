@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Blogs')
@section('content')
@section('description', 'Treiner\'s blogs will give you an insight into the soccer industry. View all our blog posts here.')
<div class="card mb-2 mt-5 p-2">    
    <h1 class="futura-bold">Blogs</h1>
</div>
    @if (count($blogs) > 0)
    <div class="row">
    @foreach ($blogs as $blog)
        <div class="col-lg-4">
        @include('blogs.component')
        </div>
    @endforeach
    </div>
    {{ $blogs->links() }}        
    @else
    <p>There are no blog entries.</p>
    @endif
@endsection

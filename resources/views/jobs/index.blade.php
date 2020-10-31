@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Search Jobs')
@section('content')
<div class="row equal">
    @if(count($jobs) == 0)
        <p>No job posts found.</p>
    @endif
    @foreach ($jobs as $jobPost)
    <div class="col-lg-4 equal">
        @include('layouts.components.job-search')
    </div>
    @endforeach
</div>
{{$jobs->links()}}
@endsection
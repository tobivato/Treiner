@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Search Jobs')
@section('content')
@section('sub-navbar')
    @include('jobs.search-navbar')
@endsection
<div class="row">
    <div class="col-sm-12 mb-4">
        <a href="https://www.algolia.com" class="text-right" target="_blank" rel="noopener">
            <img src="{{asset('img/search-by-algolia-light-background.svg')}}" alt="Search by Algolia">
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
            <div class="row">
                @if(count($jobs) == 0)
                    <p>No job posts found.</p>
                @endif
                @foreach ($jobs as $jobPost)
                <div class="col-lg-4 equal">
                    @include('layouts.components.job-search')
                </div>
                @endforeach
            </div>
            {{$jobs->appends(['distance' => $distance, 'location' => $location, 'lat' => $lat, 'lng' => $lng, 'price' => $price, 'search' => $query])->render()}}
    </div>
</div>
@endsection
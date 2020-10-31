@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Search Coaches')
@section('content')
@section('sub-navbar')
    @include('coach.search-navbar')
@endsection
<div class="row">
    <div class="col-sm-12 mb-4 text-right">
        <a href="https://www.algolia.com" target="_blank" rel="noopener">
            <img src="{{asset('img/search-by-algolia-light-background.svg')}}" alt="Search by Algolia">
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
        @if(count($coaches) == 0)
            <p>No coaches found. If you can't find a coach, try <a href="#" class="post-job">posting a job</a> and we'll give you a list of local coaches to choose from.</p>
        @endif
        @foreach ($coaches as $coach)
            <div class="col-lg-4 equal">
                @include('coach.search-component')
            </div>
        @endforeach
    </div>               
    </div>
</div>
{{$coaches->appends(['distance' => $distance, 'location' => $location, 'lat' => $lat, 'lng' => $lng, 'price' => $price, 'search' => $query])->render()}}
<script>
    analytics.track('Products Searched', {
    query: '{{$query}}'
    });
</script>
@endsection
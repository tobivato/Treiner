@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Search Coaches')
@section('content')
@section('sub-navbar')
    @include('coach.search-navbar')
@endsection
<div class="d-flex justify-content-center">
    <img src="{{asset('img/post-job-finish.svg')}}" alt="Search for coaches">
</div>
<div class="row" style="text-align:center;">
    <div class="col-sm-12">
        <h2>Search for coaches</h2>
    </div>
    <div class="col-sm-12">
        <p>Here you can search for coaches that suit your soccer training needs. If you can't find what you're looking for, try <a href="#" class="post-job">posting a job</a>.</p>
    </div>
</div>
@endsection
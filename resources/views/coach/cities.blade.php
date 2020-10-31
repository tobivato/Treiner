@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Search for soccer coaches')
@section('content')
@section('description', 'Book soccer coaching sessions with top soccer coaches on Treiner.')
<h1 class="futura-bold">View soccer coaches in your city</h1>
<div class="row equal">
    @foreach ($cities as $city => $coaches)
        <div class="col-lg-12">
            <a href="{{route('coaches.city', $city)}}">
            <div class="card card-body p-3 job-list-item" style="margin-bottom:10px;">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2 class="h3 futura-medium">{{config('treiner.cities.'.$city.'.name')}}</h2>
                            <div class="text-lg">
                                <h3 class="futura-bold">{{$coaches}} coaches</h3>
                            </div>
                            <ul class="list-unstyled">
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection
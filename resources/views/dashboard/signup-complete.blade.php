@extends('dashboard.layouts.layout')
@section('title', 'Thanks for signing up with Treiner!')
@section('content')
@if(Auth::user()->role instanceof Treiner\Coach)
    @include('dashboard.coach.signup-complete')
@else
    @include('dashboard.player.signup-complete')
@endif
@endsection
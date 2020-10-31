@extends('dashboard.layouts.layout')
@section('title', 'Camp Coaching Invitations')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.messages')
<div class="alert alert-info">
    <div class="row">
        <div class="col-sm-10">
            <h3><i class="fas fa-question-circle fa-lg"></i> Invitations</h3>
            <hr>
            <p>You can be invited to jobs by players and camps by other coaches, and this page is used to accept those invitations.</p>
            @if(count($campInvitations) == 0)
                <p>You don't currently have any camp invitations.</p>
            @endif
            @if(count($jobInvitations) == 0)
                <p>You don't currently have any job invitations.</p>
            @endif
        </div>
    </div>
  </div>

<div class="row">
    <div class="col-lg-6">
        <h3>Camp Invitations</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Camp</th>
                        <th>Accept</th>
                        <th>Deny</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($campInvitations as $invitation)
                        <tr>
                            <td><a href="{{route('camps.show', $invitation->camp)}}">{{$invitation->camp->id}}</a></td>
                            <td><a href="{{route('invitations.accept', $invitation)}}">Accept</a></td>
                            <td><a href="{{route('invitations.deny', $invitation)}}">Deny</a></td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <h3>Job Invitations</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Job</th>
                        <th>Accept</th>
                        <th>Deny</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobInvitations as $invitation)
                        <tr>
                            <td><a href="{{route('jobs.index')}}">{{$invitation->job->id}}</a></td>
                            <td><a href="{{route('offers.create', $invitation->job)}}">Accept</a></td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@extends('dashboard.layouts.layout')
@section('title', 'Live Sessions')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.messages')
<div class="alert alert-info">
    <div class="row">
        <div class="col-sm-10">
            <h3><i class="fas fa-question-circle fa-lg"></i> Live Sessions</h3>
            <hr>
            <p>Live sessions (or virtual training sessions) let you keep your soccer skills sharp while you're
                at home. You can book a coach and create a session with them, and the session will be run over Zoom using
                any camera you have available.
            </p>
            <p>Live Sessions work best on <a href="https://www.google.com/chrome">Google Chrome</a>.</p>
            @if (count(Auth::user()->player->sessionPlayers->where('session.type', 'VirtualTraining')) == 0)
                <p>You currently don't have any live sessions. To join one, either <a href="#" class="post-job">post a job</a> or <a href="{{route('coaches.welcome')}}">search for coaches that offer virtual training sessions</a>.</p>
            @endif
        </div>
    </div>
  </div>
    <table class="table">
        <thead>
            <tr>
                <th>Session ID</th>
                <th>Coach Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(Auth::user()->player->sessionPlayers->where('session.type', 'VirtualTraining') as $sessionPlayer)
                <tr>
                    <td>{{$sessionPlayer->id}}</td>
                    <td>
                        {{$sessionPlayer->session->coach->user->name}}
                    </td>
                    @if($sessionPlayer->session->zoom_number)
                    <td>
                        <a class="btn btn-primary text-right" href="{{route('live.show', $sessionPlayer->session->zoom_number)}}" role="button">Join Session</a>
                    </td>
                    @else
                    <td>
                        Please wait for the coach to create the meeting.
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
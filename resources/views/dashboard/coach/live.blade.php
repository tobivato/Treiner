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
            <p>Live sessions (or virtual training sessions) are a type of Treiner session that is run over
                Zoom, so that you can still run sessions from your home, with players joining in over their
                webcam.
            </p>
            @if(count(Auth::user()->coach->sessions->where('type', 'VirtualTraining')) == 0)
            <p>You haven't created any virtual training sessions yet.</p>
            <p>Read the <a target="_blank" href="{{asset('img/virtual_sessions.pdf')}}">guide on setting up Live Sessions</a>. You can add sessions from your <a href="{{route('home')}}">home page</a>.</p>        
            @endif
            <p>Live Sessions work best on <a href="https://www.google.com/chrome">Google Chrome</a>.</p>
        </div>
    </div>
  </div>
    <table class="table">
        <thead>
            <tr>
                <th>Session ID</th>
                <th>Players</th>
                <th>Add Zoom meeting number <i class="fa fa-info-circle" title="Go to your Zoom profile, then add your personal meeting ID or any other meeting ID you wish to use"></i></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(Auth::user()->coach->sessions->where('type', 'VirtualTraining') as $session)
                <tr>
                    <td>{{$session->id}}</td>
                    <td>
                        @foreach($session->sessionPlayers as $sessionPlayer)
                        {{$sessionPlayer->player->user->name}}
                        @endforeach
                    </td>
                    <td>
                        <form action="{{route('live.add', $session)}}" class="form-inline" method="post">
                        @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="zoom_number" value="{{$session->zoom_number}}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </td>
                    @if($session->zoom_number)
                    <td>
                        <a name="" id="" class="btn btn-primary" href="{{route('live.show', $session->zoom_number)}}" role="button">Join Session</a>
                    </td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@extends('dashboard.layouts.layout')
@section('title', 'Reports')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
    <form class="form" action="{{route('reports.store-coach')}}" method="post">
      @csrf
      @include('layouts.components.errors')
        <div class="form-group">
          <label for="defendant">Player</label>
          <select class="form-control" name="defendant_id" required id="defendant">
            @foreach ($session->sessionPlayers as $session_player)
                <option value="{{$session_player->player->id}}">{{$session_player->player->user->name}}</option>
            @endforeach
          </select>
          <small id="helpId" class="form-text text-muted">Choose the player you would like to report</small>
        </div>

        <input type="hidden" name="session_id" value="{{$session->id}}">

        <div class="form-group">
          <label for="content">Report</label>
          <textarea class="form-control" name="content" required id="content" rows="3"></textarea>
          <small id="helpId" class="form-text text-muted">Enter your report here</small>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
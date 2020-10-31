@extends('admin.layouts.layout')
@section('title', 'View Session')
@section('content')
<nav class="nav nav-tabs nav-stacked">
    <a class="nav-link active" data-toggle="tab" href="#info">Session</a>
    <a class="nav-link" data-toggle="tab" href="#players">Players <span class="badge badge-secondary badge-pill">{{count($session->sessionplayers)}}</span></a>
</nav>

<div class="tab-content">
    <div id="info" class="tab-pane active">
        <table class="table table-striped">
            <tr>
                <td>Coach</td>
                <td><a href="{{route('admin.coaches.show', $session->coach->id)}}">{{$session->coach->user->name}}</a></td>
            </tr>
            @foreach ([
                'Location' => $session->location->address,
                'Starts' => $session->starts,
                'Min Group' => $session->group_min,
                'Max Group' => $session->group_max,
                'Type' => $session->type,
                'Status' => $session->status,
                ] as $key => $val)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$val}}</td>
                </tr>
            @endforeach
            <tr>
                <td>Booking URL</td>
                <td><a href="{{route('book.store.url', $session)}}">{{route('book.store.url', $session)}}</a></td>
            </tr>
        </table>
    </div>

    <div id="players" class="tab-pane">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Session/Player ID</th>
                    <th>Player</th>
                    <th>Currency</th>
                    <th>Payment</th>
                    <th>Reviewed</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($session->sessionplayers as $sessionplayer)
                <tr>
                    <td>{{$sessionplayer->id}}</td>
                    <td><a href="{{route('admin.players.show', $sessionplayer->player->id)}}">{{$sessionplayer->player->user->name}}</a></td>
                    <td>{{$sessionplayer->payment ? $sessionplayer->payment->currency : 'N/A'}}</td>
                    <td>{{$sessionplayer->payment ? $sessionplayer->payment->formattedFee : 'N/A'}}</td>
                    @if($sessionplayer->reviewed)
                    <td>Yes</td>
                    @else
                    <td>No</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('admin.layouts.layout')
@section('title', 'View Player')
@section('content')
<nav class="nav nav-tabs nav-stacked">
        <a class="nav-link active" data-toggle="tab" href="#info">Player</a>
        <a class="nav-link" data-toggle="tab" href="#sessions">Sessions <span class="badge badge-secondary badge-pill">{{$player->sessionPlayers->count()}}</span></a>
        <a class="nav-link" data-toggle="tab" href="#jobs">Job Posts <span class="badge badge-secondary badge-pill">{{$player->jobPosts->count()}}</span></a>
    </nav>
    
    <div class="tab-content">
        <a class="btn btn-danger" href="{{route('admins.destroy', $player->user)}}" role="button">Ban {{$player->user->name}}</a>
        <div id="info" class="tab-pane active">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>{{$player->id}}</td>
                    </tr>
                    <tr>
                        <td>User ID</td>
                        <td>{{$player->user->id}}</td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td>{{$player->user->first_name}}</td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td>{{$player->user->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{$player->user->email}}</td>
                    </tr>   
                    <tr>
                        <td>Email Verified At</td>
                        <td>{{$player->user->email_verified_at}} @if(!$player->user->email_verified_at) <a href="{{route('admin.email.manual', $player->user)}}">Manually verify email</a>@endif</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>{{$player->user->phone}}</td>
                    </tr>
                    <tr>
                        <td>Currency</td>
                        <td>{{$player->user->currency}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    
        <div id="sessions" class="tab-pane">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Session/Player ID</th>
                        <th>Session ID</th>
                        <th>Coach</th>
                        <th>Currency</th>
                        <th>Fee</th>
                        <th>Reviewed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($player->sessionPlayers as $sessionPlayer)
                        <tr>
                            <td>{{$sessionPlayer->id}}</td>
                            <td>{{$sessionPlayer->session->id}}</td>
                            <td><a href="{{route('admin.coaches.show', $sessionPlayer->session->coach->id)}}">{{$sessionPlayer->session->coach->user->name}}</a></td>
                            <td>{{$sessionPlayer->session->coach->user->currency}}</td>
                            <td>{{$sessionPlayer->payment ? $sessionPlayer->payment->formattedFee : 'N/A'}}</td>
                            <td>{{$sessionPlayer->reviewed ? 'Yes' : 'No'}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="jobs" class="tab-pane">
            <table class="table table-hover">
                <thead class="thead-dark">
                            <tr>
                        <th>Job ID</th>
                        <th>Location</th>
                        <th>Starts</th>
                        <th>Fee</th>
                        <th>Type</th>
                        <th>Applications</th>
                        <th>Comments</th>
                        <th>Public URL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($player->jobPosts as $job)
                    <tr>
                        <td>{{$job->id}}</td>
                        <td>{{$job->location->address}}</td>
                        <td>{{$job->starts}}</td>
                        <td>{{$job->formattedFee}}</td>
                        <td>{{$job->type}}</td>
                        <td>{{$job->jobOffers->count()}}</td>
                        <td>{{$job->comments->count()}}</td>
                        <td>{{route('jobs.show', $job->id)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@extends('dashboard.layouts.layout')
@section('title', 'Session')
@section('content')
@section('sub-navbar')
@include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.messages')
@include('layouts.components.errors')
<div class="row no-gutters">

    <div class="col-md-12">
        <div class="mt-sm-4 mt-md-0 pl-2 pr-4">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="futura-bold"><u>{{__('coaches.'.$session->type)}}</u></h2>
                    <ul class="list-unstyled user-info-panel">
                        <li>
                            <div class="media align-items-center border-bottom border-dark py-3">
                                <div class="media-left text-center">
                                    <i class="fas fa-map-marker-alt fa-3x mr-3 text-primary"></i>
                                </div>
                                <div class="media-body">
                                    <div class="row no-gutters">
                                        <div class="col-lg-9">
                                            <p class="text-muted mb-1">Location</p>
                                            <h2 class="h4 futura-medium mb-0">{{$session->location->address}}</h2>
                                        </div>
                                        <div class="col-lg-3 align-self-end">
                                            <a href="#" data-toggle="modal" data-target="#map" class="small mb-0 d-block text-md-right"><u>View map</u></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media align-items-center border-bottom border-dark py-3">
                                <div class="media-left text-center">
                                    <i class="far fa-calendar-alt fa-3x mr-3 text-primary"></i>
                                </div>
                                <div class="media-body">
                                    <div class="row no-gutters">
                                        <div class="col-lg-9">
                                            <p class="text-muted mb-1">Date</p>
                                            <h2 class="h4 futura-medium mb-0" title="">{{$session->starts->format('D, jS F Y h:ia')}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media align-items-center border-bottom border-dark py-3">
                                <div class="media-left text-center">
                                </div>
                                <div class="media-body">
                                    <div class="row no-gutters">
                                        <div class="col-lg-9">
                                            <p class="text-muted mb-1">Cash payments</p>
                                            <h2 class="h4 futura-medium mb-0" title="">{{$session->supports_cash_payments ? 'Yes' : 'No'}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            
            <div class="job-details">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Booking Player</th>
                            <th>Player</th>
                            <th>Age</th>
                            <th>Medical information</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($session->sessionPlayers as $sessionPlayer)
                            @foreach ($sessionPlayer->player_info as $info)
                            <tr>
                                <td>{{$sessionPlayer->player->user->name}}</td>
                                <td>{{$info['name']}}</td>
                                <td>{{$info['age']}}</td>
                                <td>{{$info['medical']}}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>

@include('layouts.components.map', ['locations' => collect([$session->location])])
@endsection

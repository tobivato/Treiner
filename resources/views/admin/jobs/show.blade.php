@extends('admin.layouts.layout')
@section('title', 'View Job Post')
@section('content')
<table class="table table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Job ID</th>
            <th>Player</th>
            <th>Offers</th>
            <th>Title</th>
            <th>Type</th>
            <th>Fee</th>
            <th>Length (mins)</th>
            <th>Location</th>
            <th>Starts at</th>
            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row"><a href="{{route('admin.jobs.show', $job)}}">{{$job->id}}</a></td>
            <td><a href="{{route('admin.players.show', $job->player)}}">{{$job->player->user->name}}</a></td>
            <td>{{$job->jobOffers->count()}}</td>
            <td>{{Str::limit($job->title, 30)}}</td>
            <td>@lang('coaches.'.$job->type)</td>
            <td>{{$job->formattedFee}}</td>
            <td>{{$job->length}}</td>
            <td>{{$job->location->address}}</td>
            <td>{{$job->starts}}</td>
            <td>{{$job->created_at}}</td>
        </tr>
    </tbody>
</table>
    <p>{{$job->details}}</p>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Coach</th>
                <th>Address</th>
                <th>Fee</th>
            </tr>
        </thead>
        <tbody>
            @foreach($job->jobOffers as $offer)
            <tr>
                <td><a href="{{route('admin.coaches.show', $offer->coach)}}">{{$offer->coach->user->name}}</a></td>
                <td>{{$offer->location->address}}</td>
                <td>{{$offer->formattedFee}}</td>
            </tr>
            <tr>
                <td colspan="3">{{$offer->content}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
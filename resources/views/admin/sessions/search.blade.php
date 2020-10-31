@extends('admin.layouts.layout')
@section('title', 'Search Sessions')
@section('content')
<div class="row">
        <div class="col-sm-12">
            <form action="{{route('admin.sessions.search')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="search-id">Find session by ID</label>
                    <input type="text" name="query" class="form-control" id="search-id">
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success">Find</button>
                    </div>

                    <div class="col-sm-6">
                        <a name="create-session" id="create-session" class="btn btn-primary" href="{{route('admin.sessions.create')}}" role="button">Create</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <th>ID</th>
                    <th>Coach</th>
                    <th>Location</th>
                    <th>Starts</th>
                    <th>Minimum Players</th>
                    <th>Maximum Players</th>
                    <th>Players</th>
                    <th>Type</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    @foreach ($sessions as $session)
                        <tr>
                            <td><a href="{{route('admin.sessions.show', $session->id)}}">{{$session->id}}</a></td>
                            <td><a href="{{route('admin.coaches.show', $session->coach->id)}}">{{$session->coach->user->name}}</a></td>
                            <td>{{$session->location->locality}}</td>
                            <td>{{$session->starts->format('Y/m/d H:i')}}</td>
                            <td>{{$session->group_min}}</td>
                            <td>{{$session->group_max}}</td>
                            <td>{{count($session->sessionPlayers)}}</td>
                            <td>@lang('coaches.'.$session->type)</td>
                            <td>{{ucfirst($session->status)}}</td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
        </div>
        {{$sessions->links()}}
</div>
@endsection
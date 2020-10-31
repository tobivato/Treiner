@extends('admin.layouts.layout')
@section('title', 'Search Players')
@section('content')
@include('layouts.components.errors')
    <div class="row" style="padding-bottom:2vh;">
        <div class="col-sm-6">
            <form action="{{route('admin.players.search.id')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="search-id">Find player by ID</label>
                    <input type="text" name="query" class="form-control" id="search-id">
                </div>
                <button type="button" class="btn btn-success"">Find by ID</button>
            </form>
        </div>
        <div class="col-sm-6">
            <form action="{{route('admin.players.search.name')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="search-id">Find player by name</label>
                    <input type="text" name="query" class="form-control" id="search-id">
                </div>
                <button type="button" class="btn btn-success"">Find by name</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                        <tr>
                    <th scope="col">Profile Picture</th>
                    <th scope="col">Player ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Created At</th>
                    <th scope="col"><div class="dropdown open">
                        <button class=" dropdown-toggle" type="button" id="dropdowntrigger" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                    Actions
                                </button>
                        <div class="dropdown-menu" aria-labelledby="dropdowntrigger">
                            <button class="dropdown-item" id="select-all" href="#">Select all</button>
                            <button class="dropdown-item" id="export-csv" href="#">Export as CSV</button>
                        </div>
                    </div></th>
                </tr>
            </thead>
            <tbody>
                <form method="POST" action="{{route('admin.players.csv')}}" id="csv-form">
                @csrf
                @foreach ($players as $player)
                <tr>
                    <td><img width="50px" src="{{Cloudder::secureShow($player->user->image_id)}}"></td>
                    <td><a href="{{route('admin.players.show',$player->id)}}">{{$player->id}}</a></td>
                    <td>{{$player->user->id}}</td>
                    <td>{{$player->user->name}}</td>
                    <td>{{$player->user->dob->format('Y/m/d')}}</td>
                    <td>{{$player->user->email}}</td>
                    <td>{{$player->user->phone}}</td>
                    <td>{{$player->user->gender}}</td>
                    <td>{{$player->user->currency}}</td>
                    <td>@if($player->user->created_at){{$player->user->created_at->format('Y/m/d H:i')}}@endif</td>
                    <td><input type="checkbox" name="players[]" id="players" value="{{$player->id}}"></td>
                </tr>
                @endforeach
                </form>
            </tbody>
        </table>
    </div>
    @if(method_exists($players, 'links'))
    {{$players->links()}}
    @endif
    </div>

<script>
    let checked = false;
    document.querySelector('#select-all').addEventListener('click', function() {
        let all = document.querySelectorAll('input[type="checkbox"]').forEach(element => {
            element.checked = !checked;
        });        
        checked = !checked;
    });

    document.querySelector('#export-csv').addEventListener('click', function() {
        document.querySelector('#csv-form').submit();
    });
</script>

@endsection
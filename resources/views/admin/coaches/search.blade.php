@extends('admin.layouts.layout')
@section('title', 'Search Coaches')
@section('content')
    <div class="row" style="padding-bottom:2vh;">
        <div class="col-sm-6">
            <form action="{{route('admin.coaches.search.id')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="search-id">Find coach by ID</label>
                    <input type="text" name="query" class="form-control" id="search-id">
                </div>
                <button type="button" class="btn btn-success"">Find by ID</button>
            </form>
        </div>
        <div class="col-sm-6">
            <form action="{{route('admin.coaches.search.name')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="search-id">Find coach by name</label>
                    <input type="text" name="query" class="form-control" id="search-id">
                </div>
                <button type="button" class="btn btn-success"">Find by name</button>
            </form>
        </div>
    </div>
    <a name="csv-coaches" id="csv-coaches" class="btn btn-primary" href="{{route('coaches.csv')}}" role="button">Download all as CSV</a>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                        <tr>
                    <th scope="col">Profile</th>
                    <th scope="col">Coach ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Qualification</th>
                    <th scope="col">Club</th>
                    <th scope="col">Treiner Fee</th>
                    <th scope="col">Stripe Set</th>
                    <th scope="col">Verification</th>
                    <th scope="col">Location</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coaches as $coach)
                <tr>
                    <td><img width="50px" src="{{Cloudder::secureShow($coach->user->image_id)}}"></td>
                    <td><a href="{{route('admin.coaches.show',$coach->id)}}">{{$coach->id}}</a></td>
                    <td>{{$coach->user->id}}</td>
                    <td>{{$coach->user->name}}</td>
                    <td>{{$coach->user->dob->format('Y/m/d')}}</td>
                    <td>{{$coach->user->email}}</td>
                    <td>{{$coach->user->gender}}</td>
                    <td>{{$coach->user->currency}}</td>
                    <td>{{__('coaches.'.$coach->qualification)}}</td>
                    <td>{{Str::limit($coach->club, 20)}}</td>
                    <td>{{$coach->treiner_fee}}%</td>
                    <td>{{$coach->stripe_token ? 'Yes' : 'No'}}</td>
                    <td>{{ucfirst($coach->verification_status)}}</td>
                    <td>{{$coach->location->locality}}</td>
                    <td>@if($coach->user->created_at){{$coach->user->created_at->format('Y/m/d H:i')}}@endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$coaches->links()}}
    </div>
@endsection
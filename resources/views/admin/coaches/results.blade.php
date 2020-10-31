@extends('admin.layouts.layout')
@section('title', 'Coach Search Results')
@section('content')
<table class="table table-hover">
    <thead class="thead-dark">
    <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{$result->coach->id}}</td>
                <td>{{$result->id}}</td>
                <td>{{$result->name}}</td>
                <td>{{$result->email}}</td>
                <td>{{$result->created_at}}</td>
                <td><a href="{{route('admin.coaches.show', $result->coach->id)}}">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
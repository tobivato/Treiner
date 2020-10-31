@extends('admin.layouts.layout')
@section('title', 'All Admins')
@section('content')
@include('layouts.components.errors')
@include('layouts.components.messages')
<form action="{{route('admins.store')}}" class="form" method="post">
    @csrf
    <div class="form-group">
      <label for="first_name">First Name</label>
      <input type="text"
        class="form-control" name="first_name" id="first_name" placeholder="John">
    </div>
    <div class="form-group">
      <label for="last_name">Last Name</label>
      <input type="text"
        class="form-control" name="last_name" id="last_name" placeholder="Smith">
    </div>
    <div class="form-group">
      <label for="email">Login String</label>
      <input type="text"
        class="form-control" name="email" id="email" aria-describedby="login-help" placeholder="john-smith-admin">
      <small id="login-help" class="form-text text-muted">Login string (e.g. an email or any sort of string to allow the admin to log in)</small>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="text"
    class="form-control" name="password" id="password" value="{{Str::random(32)}}" aria-describedby="password-help" placeholder="Password">
      <small id="password-help" class="form-text text-muted">Password (must be at least 32 characters)</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div class="table-responsive">
  <table class="table table-hover">
    <thead class="thead-dark">
        <th>Name</th>
            <th>Login</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{$admin->name}}</td>
                <td>{{$admin->email}}</td>
                <td>{{$admin->created_at}}</td>
                <td>{{$admin->updated_at}}</td>
                <td>
                    <form action="{{route('admins.destroy', $admin->id)}}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <a class="btn btn-primary" href="{{route('admins.edit', $admin->id)}}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $admins->links() }}              
@endsection
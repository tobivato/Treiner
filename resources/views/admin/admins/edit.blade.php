@extends('admin.layouts.layout')
@section('title', 'Edit Admin')
@section('content')
<form action="{{route('admins.update', $user->id)}}" class="form" method="post">
        @csrf
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text"
            class="form-control" name="first_name" id="first_name" value="{{$user->first_name}}" placeholder="John">
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text"
            class="form-control" name="last_name" id="last_name" value="{{$user->last_name}}" placeholder="Smith">
        </div>
        <div class="form-group">
          <label for="email">Login String</label>
          <input type="text"
            class="form-control" name="email" id="email" value="{{$user->email}}" aria-describedby="login-help" placeholder="john-smith-admin">
          <small id="login-help" class="form-text text-muted">Login string (e.g. an email or any sort of string to allow the admin to log in)</small>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="text"
        class="form-control" name="password" id="password" aria-describedby="password-help">
          <small id="password-help" class="form-text text-muted">Password (must be at least 32 characters)</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
@endsection
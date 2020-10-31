@extends('dashboard.layouts.layout')
@section('title', 'Reports')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
<form class="form" action="{{route('reports.store-coach', $session)}}" method="post">
  @csrf
  @include('layouts.components.errors')
        <h1>Report {{$session->session->coach->user->name}}</h1>
        <div class="form-group">
          <label for="content">Report</label>
          <textarea class="form-control" required name="content" id="content" rows="3"></textarea>
          <small id="helpId" class="form-text text-muted">Enter your report here</small>
          <input type="hidden" name="defendant_id" value="{{$session->session->coach->id}}">
          <input type="hidden" name="session_id" value="{{$session->session->id}}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
@extends('dashboard.layouts.layout')
@section('title', 'Settings')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.errors')
@include('layouts.components.messages')
<div class="alert alert-info">
  <div class="row">
      <div class="col-sm-10">
          <h3><i class="fas fa-question-circle fa-lg"></i> Settings</h3>
          <hr>
          <p>The settings page lets you change your personal details, such as your name, country or phone number.</p>
      </div>
  </div>
</div>
      <div class="row">
        <div class="col-sm-12 text-right" style="margin-top:10px;">
          <form action="{{route('user.delete')}}" onsubmit="return confirm('Are you sure you want to delete your account? You won\'t be able to restore it after this.')" method="post">
            @csrf
            <button type="submit" class="btn btn-danger">Delete your account</button>
          </form>
        </div>
      </div>
      <hr>
    <form action="{{route('settings.store')}}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text"
                    class="form-control" name="first_name" id="first_name" aria-describedby="fname_help" value="{{Auth::user()->first_name}}">
                <small id="fname_help" class="form-text text-muted">Your first name</small>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text"
                    class="form-control" name="last_name" id="last_name" aria-describedby="lname_help" value="{{Auth::user()->last_name}}">
                <small id="lname_help" class="form-text text-muted">Your last name</small>
                </div>
            </div>
        </div>
        <div class="form-group">
          <label for="">Country</label>
          <select class="form-control" name="country" id="">
              @foreach (config('treiner.countries') as $key => $country)
                  @if (old('phone_country_code') == $key)
                      <option selected value="{{$key}}">{{$country["name"]}}</option>
                  @else
                      <option value="{{$key}}">{{$country["name"]}}</option>
                  @endif    
              @endforeach
          </select>
        </div>
        @if(Auth::user()->role instanceof Treiner\Coach)
        <div class="form-group">
          <label for="business_registration_number">Business Registration Number</label>
          <input type="text"
            class="form-control" name="business_registration_number" id="business_registration_number" aria-describedby="business_registration_number_help" value="{{Auth::user()->coach->business_registration_number}}">
          <small id="business_registration_number_help" class="form-text text-muted">Your business registration number (ABN or equivalent)</small>
        </div>
        @endif
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="tel"
            class="form-control" name="phone" id="phone" aria-describedby="phone_help" value="{{$phone}}">
          <small id="phone_help" class="form-text text-muted">Your phone number</small>
        </div>
        <div class="form-group">
          <label for="profile">Profile Picture</label>
              <div class="form-group custom-file">
                  <input type="file" name="profile" id="profile" class="custom-file-input"
                      aria-describedby="profile-help"></input>
                  <label for="profile" class="custom-file-label form-control">Click to select a profile
                      picture.</label>
                  <small id="profile-help" style="padding-top:10px;" class="form-text text-muted">Upload your profile picture here
                      (Must be under 8 MB, preferably square with a white background)</small>
              </div>
      </div>
        {{--<div class="form-group">
          <label for="notifications">Notification preference</label>
          <select class="form-control" name="notifications" id="notifications">
            <option>Email</option>
          </select>
        </div>--}}
        <div class="form-group">
          <label for="password">Reset password</label>
          <input type="password"
            class="form-control" name="password" id="password" aria-describedby="password_help" placeholder="">
          <small id="password_help" class="form-text text-muted">Your new password</small>
        </div>
        <div class="form-group">
          <label for="password-confirm">Confirm password</label>
          <input type="password"
            class="form-control" name="password_confirmation" id="password-confirm" aria-describedby="password-confirm_help" placeholder="">
          <small id="password-confirm_help" class="form-text text-muted">Confirm your password</small>
        </div>
        <div class="form-group">
          <div class="form-check">
            <label class="form-check-label">
              <input type="checkbox" class="form-check-input" name="newsletter" id="newsletter" @if($newsletter) checked @endif">
              @if(Auth::user()->role instanceof Treiner\Coach)    
              Receive lists of new job posts and marketing
              @else
              Receive newsletter emails
              @endif
            </label>
          </div>
        </div>
        <button type="submit" style="margin-bottom:20px;" class="btn text-right btn-primary">Submit</button>
    </form>
@endsection
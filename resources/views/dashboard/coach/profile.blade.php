@extends('dashboard.layouts.layout')
@section('title', 'Your Profile')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.errors')
@include('layouts.components.messages')
<div class="alert alert-info">
  <div class="row">
      <div class="col-sm-10">
          <h3><i class="fas fa-question-circle fa-lg"></i> Coach Profile</h3>
          <hr>
          <p>Your profile, which you can fill out below, will be shown to potential players when they
            look at your coach page. You can use this page to update the information that is shown to them.
          </p>
          <p>Additionally, changing your offered session types changes the types of session you can create.</p>
      </div>
  </div>
</div>
<div class="card text-left">
  <div class="card-body">
    <div class="row">
      <div class="col-sm-6">
        <h4>@include('layouts.components.coaches.badge') Your badge: {{ucfirst($coach->calculateBadge()['name'])}}</h4>
        <h4>You have {{$coach->calculateBadge()['score']}} points.</h4>
      </div>
      <div class="col-sm-6">
        <h4><div class="rate-stars text-primary">@include('layouts.components.coaches.stars')</div> (out of {{$coach->reviews->count()}} ratings)</h4>
      </div>
    </div>
  </div>
</div>
<hr>
<form action="{{route('home.profile.update')}}" method="post">
  @csrf
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label for="years_coaching">Number of years coaching</label>
        <input type="number"
            class="form-control" min="0" max="60" step="1" name="years_coaching" required id="years_coaching" value="{{$coach->years_coaching}}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="session_types">Session Types</label>
            <select multiple class="form-control" name="session_types[]" required id="session_types">
              @foreach (config('treiner.sessions') as $session)
                  @if(in_array($session, ($coach->session_types)))
                    <option value="{{$session}}" selected>@lang('coaches.'.$session)</option>
                  @else
                    <option value="{{$session}}">@lang('coaches.'.$session)</option>
                  @endif
              @endforeach
            </select>
          </div>      
    </div>
</div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="location">Your Main Location</label>
        <input type="text" class="form-control" required name="location" autocorrect="off" maxlength=100 id="coach-location" autocomplete="off" value="{{$coach->location->locality}}" required>
        <input type="hidden" id="lat" name="lat" value="{{$coach->location->latitude}}">
        <input type="hidden" id="lng" name="lng" value="{{$coach->location->longitude}}">
        <input type="hidden" id="country" name="country" value="{{$coach->location->country}}">
        <input type="hidden" id="locality" name="locality" value="{{$coach->location->locality}}">
      </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="qualification">Highest Coaching Qualification</label>
            <select class="form-control" name="qualification" id="qualification" required>
              @foreach (config('treiner.qualifications') as $qualification)
                  @if($coach->qualification == $qualification)
                    <option value="{{$qualification}}" selected>@lang('coaches.'.$qualification)</option>
                  @else
                    <option value="{{$qualification}}">@lang('coaches.'.$qualification)</option>
                  @endif
              @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="club">Club</label>
        <input type="text" class="form-control" name="club" id="club" required value="{{$coach->club}}">
      </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
          <label for="qualification">Age Groups</label>
          <select multiple class="form-control" name="age_groups_coached[]" id="age_groups_coached" required>
            @foreach (config('treiner.ages') as $age)
              @if(in_array($age, ($coach->age_groups_coached)))
                <option value="{{$age}}" selected>@lang('coaches.'.$age)</option>
              @else
                <option value="{{$age}}">@lang('coaches.'.$age)</option>
              @endif
            @endforeach
          </select>
      </div>
  </div>

</div>
    <div class="form-group">
      <label for="summary">Summary</label>
      <textarea class="form-control" name="profile_summary" id="summary" rows="6" required>{{$coach->profile_summary}}</textarea>
    </div>
    <div class="form-group">
      <label for="playing">Playing and Coaching Career</label>
      <textarea class="form-control" name="profile_playing" id="playing" rows="6" required>{{$coach->profile_playing}}</textarea>
    </div>
    <div class="form-group">
      <label for="philosophy">Coaching Philosophy</label>
      <textarea class="form-control" name="profile_philosophy" id="philosophy" rows="6" required>{{$coach->profile_philosophy}}</textarea>
    </div>
    <div class="form-group">
      <label for="average_session">An average session with you</label>
      <textarea class="form-control" name="profile_session" id="average_session" rows="6" required>{{$coach->profile_session}}</textarea>
    </div>
    <button type="submit" style="margin-bottom:20px;" class="btn btn-block btn-primary">Submit</button>
</form>
@endsection
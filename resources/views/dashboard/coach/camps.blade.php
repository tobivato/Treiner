@extends('dashboard.layouts.layout')
@section('title', 'Camps')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
  @endsection
  @include('layouts.components.messages')
  @include('layouts.components.errors')
<div class="alert alert-info">
  <div class="row">
      <div class="col-sm-10">
          <h3><i class="fas fa-question-circle fa-lg"></i> Camps</h3>
          <hr>
          @if(!Auth::user()->coach->verified)
          <p>Before you can start adding new camps you must be verified.</p>
          @else
          <p>Camps are a great way to run large sessions for lots of players. Camps have a few differences to
            regular sessions:
          </p>
          <ul>
              <li>Camps can be booked by up to hundreds of players</li>
              <li>They get their <a href="{{route('camps.index')}}">own pages</a> separate to the coach profile</li>
              <li>They can run over multiple days </li>
              <li>Camps will support multiple coaches that you can invite</li>
              <li>You can add a custom terms of service that players must accept</li>
          </ul>
      </div>
  </div>
</div>
<div class="text-right" style="margin-bottom:1vh;">
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#add-session" aria-expanded="false"
    aria-controls="add-session">
    Add new camp
  </button>
</div>
    <div class="collapse" id="add-session">
            <form action="{{route('camps.store')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="image">Image</label>
                            <div class="form-group custom-file">
                                <input type="file" name="image" id="image" class="custom-file-input"
                                    aria-describedby="image-help" required></input>
                                <label for="image" class="custom-file-label form-control">Click to select an image to show on your camp's page.</label>
                                <small id="image-help" class="form-text text-muted">Upload your image here (JPEG, PNG, BMP, GIF, SVG, or WebP, must have a width:height ratio of 5:1, max 20MB)</small>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text"
                        class="form-control" name="title" id="title" value="{{old('title')}}" required aria-describedby="title-help" placeholder="">
                      <small id="title-help" class="form-text text-muted">Add the title of your camp here</small>
                    </div>
                    <div class="form-group">
                      <label for="ages">Age Groups</label>
                      <select multiple class="form-control" name="ages[]" id="ages" required>
                        @foreach (config('treiner.ages') as $age)
                            <option value="{{$age}}">@lang('coaches.' . $age)</option>
                        @endforeach
                      </select>
                      <small id="ages-help" class="form-text text-muted">Add the age groups your camp caters towards here</small>
                    </div>
                    <div class="form-group">
                      <label for="group-min">Minimum Players</label>
                      <input type="number" name="group_min" id="group-min" value="{{old('group-min')}}" class="form-control" min="1" max="500" step="1" onchange="document.getElementById('group-max').min = this.value" required>
                      <small class="text-muted">The minimum number of players for this camp to run</small>
                    </div>
                    <div class="form-group">
                      <label for="group-max">Maximum Players</label>
                      <input type="number" name="group_max" id="group-max" value="{{old('group-max')}}" class="form-control" min="1" max="500" step="1" required>
                      <small class="text-muted">The maximum number of players that can be booked for this camp</small>
                    </div>
                    <div class="form-group">
                      <label for="">Starts</label>
                      <input type="date"
                      class="form-control" name="starts" value="{{old('starts')}}" min="{{Carbon\Carbon::now()->add('+6 hours')->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->add(1, 'year')->format('Y-m-d')}}" required>
                      <small class="form-text text-muted">Starting date</small>
                    </div>
                    <div class="form-group">
                      <label for="days">Days to run</label>
                      <input type="number"
                        class="form-control" name="days" id="days" value="{{old('days')}}" aria-describedby="days-help" required placeholder="">
                      <small id="days-help" class="form-text text-muted">Number of days for the camp to run for</small>
                    </div>
                    <div class="form-group">
                      <label for="start-time">Daily Start Time</label>
                      <input type="time"
                        class="form-control" name="start-time" id="start-time" value="{{old('start-time')}}" onchange="document.getElementById('end-time').min = this.value" aria-describedby="start-time-help" required placeholder="">
                      <small id="start-time-help" class="form-text text-muted">Time that your camp starts at</small>
                    </div>
                    <div class="form-group">
                      <label for="end-time">Daily End Time</label>
                      <input type="time"
                        class="form-control" name="end-time" id="end-time" value="{{old('end-time')}}" aria-describedby="end-time-help" required placeholder="">
                      <small id="end-time-help" class="form-text text-muted">Time that your camp ends at</small>
                    </div>
                    @include('layouts.components.location-search')
                    <div class="form-group">
                      <label for="">Price</label>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                        <span class="input-group-text">{{config('money.' . Auth::user()->currency . '.symbol')}}</span>
                        </div>
                        <input type="number"
                            class="form-control" step="0.01" value="{{old('fee')}}" value="0.50" min="0.5" name="fee" required aria-describedby="helpId">
                      </div>
                      <small id="helpId" class="form-text text-muted">Price per player ({{Auth::user()->currency}})</small>
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" name="description" id="description" rows="6" data-length-indicator="description-length-indicator" maxlength="5000" required placeholder="Enter a description of the camp">{{old('description')}}</textarea>
                      <small class="form-text text-right mt-2 text-muted"><span id="description-length-indicator">5000</span> characters remaining</small>
                    </div>
                    <div class="form-group">
                      <label for="tos">Terms of Service</label>
                      <textarea class="form-control" name="tos" id="tos" rows="6" required maxlength="10000" data-length-indicator="tos-length-indicator" placeholder="Enter the terms of service for your camp">{{old('tos')}}</textarea>
                      <small class="form-text text-right mt-2 text-muted"><span id="tos-length-indicator">10000</span> characters remaining</small>
                    </div>
                    <div class="form-group">
                      <label for="coaches"></label>
                      <select multiple class="form-control" name="coaches[]" id="coaches">
                        @foreach (\Treiner\Coach::all() as $coach)
                            <option value="{{$coach->id}}">{{$coach->user->name}}</option>
                        @endforeach
                      </select>
                      <small id="helpId" class="form-text text-muted">Invite coaches to coach at this camp.</small>
                    </div>

                    <button type="submit" class="btn-block">Create</button>
                </form>
        </div>
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Session ID</th>
                    <th>Title</th>
                    <th>Age Groups</th>
                    <th>Bookings</th>
                    <th>Edit</th>
                    <th>Download Player Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Auth::user()->coach->camps->sortByDesc('session.starts') as $camp)
                <tr>
                    <td scope="row">{{$camp->id}}</td>
                    <td>{{$camp->session->id}}</td>
                    <td>{{$camp->title}}</td>
                    <td>{{$camp->formattedAges}}</td>
                    <td>{{$camp->session->playersCount}} / {{$camp->session->group_max}}</td>
                    <td><a href="{{route('camps.edit', $camp)}}">Edit</a></td>
                    <td><a href="{{route('camps.csv', $camp)}}">Download</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
@endsection
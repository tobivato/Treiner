@extends('admin.layouts.layout')
@section('title', 'Create session')
@section('content')
<form method="POST" action="{{route('admin.sessions.store')}}">
    @csrf
    @include('layouts.components.errors')
    <div class="form-group">
        <div class="form-group">
          <label for="coach-id">Coach ID</label>
          <input type="number"
            class="form-control" name="coach-id" id="coach-id" aria-describedby="coach-id-help" placeholder="">
          <small id="coach-id-help" class="form-text text-muted">Enter the ID of the coach for this session</small>
        </div>
        <label for="group-min">Minimum</label>
        <input type="number" name="group_min" id="group-min" class="form-control" min="1" value="1"
            max="16" step="1" onchange="document.getElementById('group-max').min = this.value" required>
        <small class="text-muted">The minimum number of players for this session to run</small>
    </div>
    <div class="form-group">
        <label for="group-max">Maximum</label>
        <input type="number" name="group_max" id="group-max" class="form-control" value="1" min="1"
            max="16" step="1" required>
        <small class="text-muted">The maximum number of players that can be booked for this
            session</small>
    </div>

    <div class="form-group">
        <select class="form-control" name="type" required>
            @foreach(config('treiner.sessions') as $type)
            <option value={{$type}}>@lang('coaches.' . $type)</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span
                    class="input-group-text">{{config('money.' . Auth::user()->currency . '.symbol')}}</span>
            </div>
            <input type="number" class="form-control" step="0.01" value="0.50" min="0.5" name="fee"
                required aria-describedby="helpId">
        </div>
        <small id="helpId" class="form-text text-muted">Price per hour
            ({{Auth::user()->currency}})</small>
    </div>

    @include('layouts.components.location-search')

        <div class="form-group">
            <input type="datetime-local" class="form-control" name="starts"
                value="{{Carbon\Carbon::now()->add('+6 hours')->format('Y-m-d\TH:i')}}"
                min="{{Carbon\Carbon::now()->add('+6 hours')->format('Y-m-d\TH:i')}}"
                max="{{Carbon\Carbon::now()->add(1, 'year')->format('Y-m-d\TH:i')}}" required>
            <small class="form-text text-muted">Starts at</small>
        </div>
        <p class="text-center text-muted futura-medium mt-2">You also need to choose how long
            you want this session to run for.</p>
        <div class="form-group">
            <select class="form-control" name="length" required>
                <option value=30>30 minutes</option>
                <option value=60>60 minutes</option>
                <option value=90>90 minutes</option>
                <option value=120>120 minutes</option>
                <option value=150>150 minutes</option>
                <option value=180>180 minutes</option>
            </select>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-check">
                    <p class="text-center text-muted futura-medium mt-2">
                        <input type="checkbox" name="hourly_recurrence" class="form-check-input"
                            id="hourly-recurrence" onchange="$('#hourly-recurring').toggle()">
                        <span onclick="$('#hourly-recurrence').click()">Will you be available at
                            this venue for more than one session?</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="row" id="hourly-recurring" style="display:none">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="hourly-recur-for"></label>
                    <input type="number" class="form-control" min="1" max="12"
                        name="hourly_recur_for" id="hourly-recur-for">
                    <small id="hourly-recur-help" class="form-text text-muted">How many
                        more sessions?</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-check">
                    <p class="text-center text-muted futura-medium mt-2">
                        <input type="checkbox" name="recurring_change" class="form-check-input"
                            id="recurring-change" onchange="$('#recurring').toggle()">
                        <span onclick="$('#recurring-change').click()">You can also have the session
                            repeat on specific days according to your requirements.</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="row" id="recurring" style="display:none">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="recur"></label>
                    <select class="form-control" name="recur" id="">
                        <option value="daily">Daily</option>
                        <option value="second-day">Every second day</option>
                        <option value="weekly">Weekly</option>
                        <option value="fortnightly">Fortnightly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                    <small class="form-text text-muted">Recur</small>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="recur-for"></label>
                    <input type="number" class="form-control" min="1" max="9" name="recur_for"
                        id="recur-for" placeholder="">
                    <small id="recur-help" class="form-text text-muted">How many times?</small>
                </div>
            </div>
        </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

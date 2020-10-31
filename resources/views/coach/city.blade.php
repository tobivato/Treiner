@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Top soccer coaches in ' . $cityName)
@section('content')
@section('description', 'Book soccer coaching sessions with top soccer coaches in ' . $cityName . ' on Treiner.')
@section('schema')
@include('schema.city')
@endsection

<div class="card mb-2 p-2">
    <h1 class="futura-bold">Private Soccer Coaches in {{$cityName}}</h1>
    <p>Treiner offers soccer coaching sessions with a whole host of trained, vetted coaches. If you're looking for
        any variety of soccer coach or practitioner Treiner has got you sorted.
    </p>
</div>
<div class="sticky-top card mb-2 p-2" >
    <form class="search-form" method="GET" action="{{route('coaches.city', $city)}}">
        @include('layouts.components.errors')
        @include('layouts.components.messages')
        @csrf
        <div class = "form-row">
            <div class="col-lg-4 col-md-3 col-6">
                <label>Session Type</label>
                <select class="form-control" name="session" value="{{($data !=null)?$data['session']:""}}">
                <option></option>
                @foreach(config('treiner.sessions') as $session)
                        <option value="{{$session}}" {{($data !=null && $data['session'] == $session)?'selected':""}}>@lang('coaches.' . $session)</option>
                    @endforeach
                    </select>
            </div>

            <div class="col-lg-3 col-md-3 col-6">
                <label>Qualification</label>
                <select class="form-control" data-placeholder="Select qualification" name="qualification" value="{{($data !=null)?$data['qualification']:""}}">
                <option></option>
                @foreach(config('treiner.qualifications') as $qualification)
                        <option value="{{$qualification}}" {{($data !=null && $data['qualification'] == $qualification)?'selected':""}}>@lang('coaches.' . $qualification)</option>
                    @endforeach
                    </select>
            </div>
            <div class="col-lg-4 col-md-4 col-8">
                <label for="location">{{__('Town or suburb')}}</label>
                <div>
                    <input type="text" class="form-control" name="location" maxlength=100 placeholder="Enter the town or suburb where you are" id="coach-location-search">
                </div>
            </div>

            <div class="col-lg-1 col-md-2 col-4">
                <label></label>
                <button type="submit" class="btn btn-primary btn-block mt-2">Search</button>
            </div>
        </div>
        <a href="#" class="float-right p-1 m-1" data-toggle="modal" data-target="#exampleModal">more options</a>
    </form>

</div>
<div class="row equal">
    @foreach ($coaches as $coach)
        <div class="col-lg-4">
            @include('coach.search-component')
       </div>
    @endforeach
    {{$coaches->links()}}
</div>
<div class="card mb-2 mt-5 p-2">
    <h3 class="futura-bold">Didn't find what you're looking for?</h3>
    <p>Try <a href="#" class="post-job">posting a job</a> instead. By posting a job you'll have total control
        over the type of session you want to run, the place you want to run it, the price that you'll pay and
        the time that you start.
    </p>
</div>
@endsection


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Advance Search</h5>
      </div>
      <div class="modal-body">
        <form class="search-form" method="GET" action="{{route('coaches.city', $city)}}">
        @include('layouts.components.errors')
        @include('layouts.components.messages')
        @csrf
            <div class="form-group row">
                <label class="col-md-4 col-form-label">Name</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" autocomplete="no" value="{{($data !=null)?$data['name']:""}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label" for="location">{{__('Town or suburb')}}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="location" autocorrect="off" maxlength=100 placeholder="Enter the town or suburb where you are based, then choose a location from the list." id="coach-location-modal" autocomplete="off">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label">Experience</label>
                <div class="col-md-8">
                    <input type="number" min="0" max="50" class="form-control" name="experience" value="{{($data !=null)?$data['experience']:""}}">
                </div>
            </div>
            {{-- <div class="form-group row">
                <label class="col-md-4 col-form-label">Fee</label>
                <div class="col-md-8">
                    <select class="form-control" name="price" value="{{($data !=null)?$data['price']:""}}">
                        <option></option>
                        @foreach(config('treiner.price_ranges') as $ranges)
                            <option value="{{$ranges}}" {{($data !=null && $data['price'] == $ranges)?'selected':""}}>@lang($ranges)</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="form-group row">
                <label class="col-md-4 col-form-label">Qualification</label>
                <div class="col-md-8">
                    <select class="form-control" data-placeholder="Select qualification" name="qualification" value="{{($data !=null)?$data['qualification']:""}}">
                        <option></option>
                        @foreach(config('treiner.qualifications') as $qualification)
                            <option value="{{$qualification}}" {{($data !=null && $data['qualification'] == $qualification)?'selected':""}}>@lang('coaches.' . $qualification)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label">Session Type</label>
                <div class="col-md-8">
                    <select class="form-control" name="session" value="{{($data !=null)?$data['session']:""}}">
                        <option></option>
                        @foreach(config('treiner.sessions') as $session)
                            <option value="{{$session}}" {{($data !=null && $data['session'] == $session)?'selected':""}}>@lang('coaches.' . $session)</option>
                        @endforeach
                    </select>
                </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>
      </div>
    </div>
  </div>
</div>

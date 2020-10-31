@extends('layouts.app')
@section('title', 'Support')
@section('content')
<h3>Support</h3>
<div class="row">
    <div class="col-lg-12">
        <h5>Open a Ticket</h5>
            <form class="form-horizontal" action="{{route('support')}}" method="POST">
              @csrf
              @include('layouts.components.errors')
              @include('layouts.components.messages')      
              <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" class="form-control" id="title" maxlength="50" placeholder="Title" required/>
                    </div>
                  
                    <div class="form-group">
                        <label for="severity">Severity</label>
                        <select class="form-control" name="severity" id="severity" required>
                          <option value="low">Low</option>
                          <option value="medium">Medium</option>
                          <option value="high">High</option>
                          <option value="extreme">Extreme</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="type">Type</label>
                      <select class="form-control" name="type" id="type" required>
                        <option value="bug">Bug</option>
                        <option value="help">Help</option>
                        <option value="finance">Finance</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="descField" class="col-xs-2">Comments</label>
                      <div class="col-xs-12">
                        <textarea class="form-control" required data-length-indicator="length-indicator" maxlength="10000" name="comments" id="descField" rows="5" placeholder="Your comments"></textarea>
                        <small class="text-muted d-block pt-2 text-right"><span id="length-indicator">10000</span> characters left</small>
                      </div>
                    </div>
                    
                    <div class="col-xs-10 col-xs-offset-2">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    
            </form>
    </div>
</div>
@endsection
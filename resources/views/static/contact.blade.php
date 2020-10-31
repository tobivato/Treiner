@extends('layouts.app')
@section('title', 'Contact')
@section('content')
@section('description', 'At Treiner we\'re here to assist you. This page will let you contact us.')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div>
                <h1><span>Contact us</span></h1>
                <p>We’re here to assist you. {{--Browse through our <a href="/faq">FAQ</a> for help. Still have a question we haven’t covered in our <a href="/faq">FAQ</a>?--}} Send us a message with the form below!</p>
            </div>    
            <form class="form" method="post" action="{{route('contact')}}">
                @csrf
                @include('layouts.components.errors')
                @include('layouts.components.messages')
                <div class="row">
                    <div class="form-group" style="display:none;">
                        <label for="faxonly">Contact me by fax only</label>
                        <input type="checkbox" name="faxonly" checked="true" id="faxonly">
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {                                
                                document.getElementById("faxonly").checked = false;
                            }); 
                        </script>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fname"> First Name:</label>
                            <input type="text" name="fname" autocomplete="given-name" maxlength="50" required value="{{old('fname')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="lname"> Last Name:</label>
                            <input type="text" name="lname" autocomplete="family-name" maxlength="50" required value="{{old('lname')}}" class="form-control">
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" name="email" class="form-control" autocomplete="email" maxlength="200" required value="{{old('email')}}" id="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group">
                            <label for="comment">How can we help you?</label>
                            <textarea class="form-control" data-length-indicator="length-indicator" name="content" rows="5" id="comment" required maxlength="10000">{{old('content')}}</textarea>
                            <small class="text-muted d-block pt-2 text-right"><span id="length-indicator">10000</span> characters left</small>
                        </div>
                    </div>
                </div>
                  <button type="submit" class="btn btn-primary">Send</button>

            </form>
        </div>
    </div>
   
</div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Login')
@section('content')
@section('description', 'Login to your Treiner account and begin searching for coaching opportunities to boost your soccer skills.')
<section>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3-large"><span>Sign In</span></h1>
                </div>
                <div class="card-body">
                    <form id="sign-in-form" method="post">
                        @csrf
                        @include('layouts.components.errors')

                        <div class="form-group row">
                            <label for="exampleInputEmail1" class="col-md-12 col-form-label text-md-left">Email</label>
                            <div class="col-md-12">
                                <input name="email" type="email" class="form-control" autocapitalize="off" autocomplete="email" value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-form-label text-md-left">Password</label>
                            <div class="col-md-12">
                                <input id="password-field" name="password" class="form-control" autocapitalize="off" autocomplete="current-password" type="password" required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>
                        <div class="form-group row mb-2r">
                            {{--<div class="custom-control custom-checkbox col-md-6">
                                <input type="checkbox" name="keeploggedin" id="keeploggedin" checked
                                    class="custom-control-input">
                                <label for="keeploggedin" class="custom-control-label">
                                    Keep me logged in
                                </label>
                            </div>--}}
                            <div class="col-md-12 text-md-right">
                                <input class="btn btn-primary" type="submit" value="Sign In">
                            </div>
                        </div>
                        <div class="form-group row form-footer">
                            <div class="col-md-6">
                                <a href="{{route('password.request')}}">Forgot your password?</a>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <a href="{{route('register')}}">Don't have a Treiner account? Register now!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <script>
        document.querySelector('#sign-in-form').addEventListener('keyup', function(e) {
            if (e.keyCode === 13) {
                $('#sign-in-form').submit();
            }
        });
    </script>
</section>
@endsection

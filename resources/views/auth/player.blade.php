@extends('layouts.app')
@section('title', 'Register as a Player')
@section('content')
@section('description', 'Register for a Treiner account so that you can begin searching for the perfect soccer coach to help you boost your skills.')
<div class="row justify-content-center register-container">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h1 class="h3-large"><span>{{ __('Register as a Player') }}</span></h1>
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                    @csrf
                    @include('layouts.components.errors')

                    <div class="form-group row">
                        <label for="firstName"
                            class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                        <div class="col-md-7">
                            <input id="firstName" autocomplete="given-name" type="text"
                                class="form-control @error('firstName') is-invalid @enderror" name="firstName"
                                value="{{ old('firstName') }}" required maxlength="255" autocomplete="firstName"
                                placeholder="{{ __('Enter your first name.') }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lastName"
                            class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                        <div class="col-md-7">
                            <input id="lastName" type="text" autocomplete="family-name"
                                class="form-control @error('lastName') is-invalid @enderror" name="lastName"
                                value="{{ old('lastName') }}" required maxlength="255" autocomplete="lastName"
                                placeholder="{{ __('Enter your last name.') }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email address</label>

                        <div class="col-md-7">
                            <input id="email" autocomplete="email" maxlength="255" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="Enter your email address." required
                                autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dob" class="col-md-4 col-form-label text-md-right">
                        {{ __('Date Of Birth ') }}</label>

                        <div class="col-md-7">
                            <input id="dob" type="date" data-focus-tooltip="true" title="You must be over the age of 16 to create a Treiner player account. 
                            Otherwise, a parent or guardian must create your account." autocomplete="bday" required
                                min="{{\Carbon\Carbon::now()->add('-122 years')->format('Y-m-d')}}"
                                max="{{\Carbon\Carbon::now()->add('-16 years')->format('Y-m-d')}}"
                                class="form-control @error('dob') is-invalid @enderror" name="dob"
                                value="{{ old('dob') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                        <div class="col-md-7">
                            <select name="gender" required autocomplete="sex" class="custom-select form-control"
                                id="gender">
                                <option value="" disabled selected>
                                    {{ __('Select your gender from the drop down list.') }}</option>
                                @foreach (['male' => 'Male', 'female' => 'Female'] as $key => $value)
                                    @if (old('gender') == $key)
                                        <option selected value="{{$key}}">{{ __($value) }}</option>
                                    @else
                                        <option value="{{$key}}">{{ __($value) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone_country_code"
                            class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
                        <div class="col-md-7">
                            <select name="phone_country_code" required class="custom-select form-control" id="country">
                                @foreach (config('treiner.countries') as $key => $country)
                                    @if (old('phone_country_code') == $key)
                                        <option selected value="{{$key}}">{{$country["name"]}}</option>
                                    @else
                                        <option value="{{$key}}">{{$country["name"]}}</option>
                                    @endif    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>
                        <div class="col-md-7">
                            <input id="phone" autocomplete="tel-national" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="{{ __('Enter your phone number.') }}" required value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-7">
                            <input id="password" autocomplete="new-password" minlength="8" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Choose a strong and secure password." required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-7">
                            <input id="password-confirm" autocomplete="new-password" minlength="8" type="password"
                                class="form-control @error('password-confirm') is-invalid @enderror"
                                name="password_confirmation" placeholder="Confirm your password." required
                                autocomplete="new-password">
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox offset-sm-4">
                        <input type="checkbox" name="newsletter" id="newsletter" checked class="custom-control-input">
                        <label for="newsletter" class="custom-control-label">
                            Sign up to our newsletter
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox offset-sm-4">
                        <input type="checkbox" required class="custom-control-input" name="terms" id="terms">
                        <label for="terms" class="custom-control-label">
                            I agree to the <a target="_blank" href="{{route('terms')}}">terms and conditions</a>
                        </label>
                    </div>

                    <input type="hidden" name="user_type" id="user_type" value="player">

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

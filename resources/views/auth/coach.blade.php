@extends('layouts.app')
@section('title', 'Register as a Coach')
@section('content')
@section('description', 'Register for a Treiner account and start coaching on our platform.')
    <div class="row justify-content-center register-container">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3-large"><span>{{ __('Register as a Coach') }}</span></h1>
                </div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                        @csrf
                        @include('layouts.components.errors')

                        <div class="form-group row">
                                <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                                <div class="col-md-7">
                                    <input id="firstName" autocomplete="given-name" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required maxlength="255" autocomplete="firstName" placeholder="{{ __('Enter your first name.') }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                                <div class="col-md-7">
                                    <input id="lastName" type="text" autocomplete="family-name" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required maxlength="255" autocomplete="lastName" placeholder="{{ __('Enter your last name.') }}" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date Of Birth ') }}<i class="fas fa-question-circle" title="You must be over the age of 18 to coach for Treiner."></i></label>

                                <div class="col-md-7">
                                    <input id="dob" type="date" autocomplete="bday" required min="{{\Carbon\Carbon::now()->add('-122 years')->format('Y-m-d')}}" max="{{\Carbon\Carbon::now()->add('-18 years')->format('Y-m-d')}}" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}">
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
                                    <select name="phone_country_code" required class="custom-select form-control" id="ph-country">
                                        <option value="" disabled selected>
                                            {{ __('Select your country from the drop down list.') }}</option>
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
                                <label for="location" class="col-md-4 col-form-label text-md-right">{{__('Town or suburb')}}</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" required name="location" autocorrect="off" maxlength=100 placeholder="Enter the town or suburb where you are based, then choose a location from the list." id="coach-location" autocomplete="off" required>
                                    <input type="hidden" id="lat" name="lat">
                                    <input type="hidden" id="lng" name="lng">
                                    <input type="hidden" id="country" name="country">
                                    <input type="hidden" id="locality" name="locality">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>
                                <div class="col-md-7">
                                    <input id="phone" autocomplete="tel-national" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="{{ __('Enter your phone number.') }}" required value="{{ old('phone') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email address</label>

                                <div class="col-md-7">
                                    <input id="email" autocomplete="email" maxlength="255" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email address." required autocomplete="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-7">
                                    <input id="password" autocomplete="new-password" minlength="8" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Choose a strong and secure password." required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-7">
                                    <input id="password-confirm" autocomplete="new-password" minlength="8" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" placeholder="Confirm your password." required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="profile">Profile Picture</label>
                                <div class="col-md-7">
                                    <div class="form-group custom-file">
                                        <input type="file" name="profile" required id="profile" class="custom-file-input" aria-describedby="profile-help"></input>
                                        <label for="profile" class="custom-file-label form-control">Click to select a profile picture.</label>
                                         <small id="profile-help" class="form-text text-muted">Upload your profile picture here (Must be under 8 MB, preferably square with a white background. For best results ensure that you are the only person in the photo so as not to confuse potential players.)</small>
                                    </div>
                                </div>
                            </div>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="coachContent" role="tabpanel" aria-labelledby="coachContent-tab">
                                <div class="form-group row">
                                    <label for="business_type" class="col-md-4 col-form-label text-md-right">{{ __('Business Type') }}</label>
                                    <div class="col-md-7">
                                        <select name="business_type" required class="custom-select form-control" id="business_type">
                                                <option value="" disabled selected>{{ __('Select from the drop down list.') }}</option>
                                                <option value="individual">{{ __('Sole Proprietor') }}</option>
                                                <option value="company">{{ __('Other') }}</option>
                                            </select>
                                        </div>
                                </div>

                                <div class="form-group row">
                                    <label for="verification_type" class="col-md-4 col-form-label text-md-right">{{ __('Working with Children Licence Type') }}</label>
                                    <div class="col-md-7">
                                        <select id="verification_type" class="custom-select form-control @error('verification_type') is-invalid @enderror" required name="verification_type">
                                            <option value="" disabled selected>Select from the drop down list.</option>
                                            @foreach (config('treiner.verification_types') as $level)
                                                <option value="{{$level}}">@lang('coaches.' . $level)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="verification" class="col-md-4 col-form-label text-md-right">{{ __('Licence Number') }}</label>
                                    <div class="col-md-7">
                                        <input id="verification" type="text" class="form-control @error('verification') is-invalid @enderror" name="verification" placeholder="{{ __('Enter your working with children licence number.') }}" required value="{{ old('verification') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="abn" class="col-md-4 col-form-label text-md-right">Business Number</label>
                                    <div class="col-md-7">
                                        <input id="abn" type="text" class="form-control @error('abn') is-invalid @enderror" name="abn" placeholder="Enter your business registration number (ABN or equivalent)." maxlength="255" required value="{{ old('abn') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="club" class="col-md-4 col-form-label text-md-right">Current Club</label>
                                    <div class="col-md-7">
                                        <input id="club" type="text" class="form-control @error('club') is-invalid @enderror" name="club" required maxlength="255" value="{{ old('club') }}" placeholder='Enter the current club or academy that you are at.'>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="age_groups_coached" class="col-md-4 col-form-label text-md-right">Age Groups Coached</label>
                                    <div class="col-md-7">
                                        <select id="age_groups_coached" data-placeholder="Select the age groups you have coached." name="age_groups_coached[]" required class="@error('profile') is-invalid @enderror" multiple>
                                            @foreach (config('treiner.ages') as $age)
                                                <option value="{{$age}}">@lang('coaches.' . $age)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="qualification" class="col-md-4 col-form-label text-md-right">Highest Coaching Qualification</label>
                                    <div class="col-md-7">

                                        <select id="qualification" class="custom-select form-control @error('qualification') is-invalid @enderror" required name="qualification">
                                            <option value="" disabled selected>Select from the drop down list.</option>
                                            @foreach(config('treiner.qualifications') as $qualification)
                                             <option value="{{$qualification}}">@lang('coaches.' . $qualification)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label for="fee" class="col-md-4 col-form-label text-md-right">Fee per hour</label>
                                    <div class="col-md-7">
                                        <input id="fee" type="number" class="form-control @error('fee') is-invalid @enderror" required min="0" name="fee" value="{{ old('fee') }}" placeholder="Enter fee per hour.">
                                    </div>

                                </div> --}}

                                <div class="form-group row">
                                    <label for="years_coaching" class="col-md-4 col-form-label text-md-right">Total years coaching</label>
                                    <div class="col-md-7">
                                        <input id="year_coaching" type="number" class="form-control @error('years_coaching') is-invalid @enderror" required max="60" min="0" name="years_coaching" value="{{ old('years_coaching') }}" maxlength="2" placeholder="Enter the number of years you have coached for.">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for=session_types class="col-md-4 col-form-label text-md-right">Session Types</label>
                                        <div class="col-md-7">
                                            <select id="session_types" data-placeholder="Select the types of session you would like to coach" required class="form-control @error('session_types') is-invalid @enderror" name="session_types[]" multiple aria-hidden="true">
                                                @foreach (config('treiner.sessions') as $session)
                                                <option value="{{$session}}">@lang('coaches.' . $session)</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for=session_types class="col-md-4 col-form-label text-md-right">Coaching Summary</label>
                                    <div class="col-md-7">
                                        <textarea class="form-control @error('profile_summary') is-invalid @enderror" required maxlength="1000" data-length-indicator="summary-length-indicator" placeholder="Summarise your approach to coaching and what motivates you as a coach." name="profile_summary">{{ old('profile_summary') }}</textarea>
                                        <small class="form-text text-right mt-2 text-muted"><span id="summary-length-indicator">1000</span> characters remaining</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for=session_types class="col-md-4 col-form-label text-md-right">Coaching Philosophy</label>
                                    <div class="col-md-7">
                                        <textarea class="form-control @error('profile_philosophy') is-invalid @enderror" required maxlength="1000" data-length-indicator="philosophy-length-indicator" name="profile_philosophy" placeholder="Tell us a bit about the philosophy behind your coaching style and what you hope to teach your athletes.">{{ old('profile_philosophy') }}</textarea>
                                        <small class="form-text text-right mt-2 text-muted"><span id="philosophy-length-indicator">1000</span> characters remaining</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for=session_types class="col-md-4 col-form-label text-md-right">Career Experience</label>
                                    <div class="col-md-7">
                                        <textarea class="form-control @error('profile_playing') is-invalid @enderror" required maxlength="1000" data-length-indicator="playing-length-indicator" name="profile_playing" placeholder="Explain your career with soccer, whether it's playing soccer or coaching.">{{ old('profile_playing') }}</textarea>
                                        <small class="form-text text-right mt-2 text-muted"><span id="playing-length-indicator">1000</span> characters remaining</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for=session_types class="col-md-4 col-form-label text-md-right">Average Session</label>
                                    <div class="col-md-7">
                                        <textarea class="form-control @error('profile_session') is-invalid @enderror" data-length-indicator="average-length-indicator" required maxlength="1000" name="profile_session" placeholder="What would an average training session be like with you? What should an athlete expect before booking your services?">{{ old('profile_session') }}</textarea>
                                        <small class="form-text text-right mt-2 text-muted"><span id="average-length-indicator">1000</span> characters remaining</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox offset-sm-4">
                            <input type="checkbox" name="newsletter" id="newsletter" checked class="custom-control-input">
                            <label for="newsletter" class="custom-control-label">
                                Receive notifications when new jobs are posted near you, and also marketing material
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox offset-sm-4">
                            <input type="checkbox" required class="custom-control-input" name="terms" id="terms">
                                <label for="terms" class="custom-control-label">
                                    I agree to the <a target="_blank" href="{{route('terms')}}">terms and conditions</a>
                                </label>
                        </div>

                        <input type="hidden" name="user_type" id="user_type" value="coach">

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

<script>
    document.querySelector('#country').addEventListener("change", function() {
        let e = document.getElementById("country");
        let country = e.options[e.selectedIndex].value;

        switch (country) {
            case "australia":
                document.getElementById('abn').setAttribute("placeholder", "Enter your Australian Business Number.")
                break;
            case "new_zealand":
                document.getElementById('abn').setAttribute("placeholder", "Enter your New Zealand Business Number.")
                break;
            /*case "malaysia":
                document.getElementById('abn').setAttribute("placeholder", "Enter your Malaysian company registration number.")
                break;*/
            default:
                document.getElementById('abn').setAttribute("placeholder", "Enter your business registration number, TIN or EIN.")
                break;
        }
    });
</script>
@endsection

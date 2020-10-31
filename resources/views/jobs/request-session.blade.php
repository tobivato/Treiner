<!-- Modal -->
<div class="modal post-job-modal fade" id="postJob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="msform" method="POST" action="{{route('jobs.store')}}">
                @csrf
                <input type="hidden" name="invite_coach" value="{{$coach->id}}">
                <fieldset class="fieldsetStep" data-name="begin">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Request a session from {{$coach->user->name}}</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <img class="w-75" src="{{asset('img/post-job-start.svg')}}" alt="Request a session">
                                <h5 class="h3 futura-bold text-center mt-4">Request a session today!</h5>
                                <p class="text-center futura-medium mt-2">Take a moment to go through the process of
                                    posting a job that will be sent to {{$coach->user->first_name}}. If the coach can't
                                    coach this session, other coaches will be able to bid for it.</p>
                            </div>
                        </div>
					</div>
                    <button class="next action-button btn btn-primary btn-md" value="Next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="title">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">What are you looking for?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">What do you need {{$coach->user->first_name}} to help you with?
                                </h5>
                                <p class="text-center text-muted futura-medium mt-2">This will be the title of your job.
                                    Please keep it short and accurately describe what you need.</p>
                                <div class="form-group">
                                    <select data-length-indicator="title-length-indicator" id="job-post-title" required maxlength="32" name="title" 
                                        class="form-control" data-placeholder="E.g “Goalkeeper Training 1 on 1”" data-next="title-next">
                                        <option></option>
                                        <option>Ball Mastery</option>
                                        <option>First touch</option>
                                        <option>Running with the ball</option>
                                        <option>Striking the ball (shooting or passing)</option>
                                        <option>1v1 (defending or attacking)</option>
                                        <option>Non-dominant foot</option>
                                        <option>GK specific</option>
                                        <option>General fitness</option>
                                        <option>Strength, speed or agility</option>
                                    </select>
                                    <small class="form-text text-right mt-2 text-muted"><span id="title-length-indicator">32</span> characters remaining</small>
                                </div>
                                <p class="text-center futura-medium mt-5">Requesting a session is free! Treiner takes a 10% cut
                                    from what you pay the coach and deducts GST. Payment is easy, secure and fast, we
                                    try to make this as easy for you as possible!</p>
                            </div>
                        </div>
                    </div>
                    <button class="next action-button btn btn-primary btn-md" disabled value="Next" id="title-next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="session-type">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">What are you looking for?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Please select a training category.</h5>
                                <div class="form-group">
                                    <select required class="form-control" name="type" id="session">
                                        @foreach ($coach->session_types as $session)
                                        	<option value="{{$session}}">@lang('coaches.'.$session)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" value="Next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="description">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">What are you looking for?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Please describe what kind of session you want from {{$coach->user->first_name}}.</h5>
                                <p class="text-center text-muted futura-medium mt-2">Try to be as specific as possible
                                    with describing the job. Also please do not disclose any personal information.</p>
                                    <div class="form-group">
                                    <textarea required maxlength="1500" id="job-textarea" data-length-indicator="details-length-indicator" minlength="50" class="form-control" data-next="details-next" name="details" rows="8"></textarea>
                                    <small class="form-text text-right mt-2 text-muted">50 characters required, <span id="details-length-indicator">1500</span> characters remaining</small>
                                </div>
                            </div>
                        </div>
					</div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" disabled value="Next" id="details-next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="length">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">How many minutes?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Choose how many minutes you need to train
                                    for.</h5>
                                <p class="text-center text-muted futura-medium mt-2">Decide how many minutes you need to
                                    practice with {{$coach->user->first_name}}.</p>
                                <div class="row justify-content-center">
                                    <div class="col-auto"> </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <input type="number" required min="30" data-next="length-next" max="180" step="1" name="length"
                                                class="form-control form-control-lg futura-bold text-dark h2 text-center d-inline mb-0"
                                                placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-auto align-self-end pl-0"><small
                                            class="form-text text-right mt-2 text-muted">minutes</small></div>
                                </div>
                                <p class="text-center futura-medium mt-5">Enter the amount of minutes you would like to
                                    train with your coach for, in the box above.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" disabled value="Next" id="length-next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="budget">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">What is your budget?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Choose how much you want to pay {{$coach->user->name}}.
                                </h5>
                                <p class="text-center text-muted futura-medium mt-2">This will set the rate you
                                    offer to pay your coach, although they don't necessarily have to accept it.</p>
                                <div class="row justify-content-center">
                                    <div class="col-auto"> </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend futura-bold">
                                                    <span
                                                        class="input-group-text">{{config('money.' . Auth::user()->currency . '.symbol')}}</span>
                                                </div>
                                                <input type="number"
                                                    class="form-control form-control-lg futura-bold text-dark"
                                                    step="0.01" min="0.5" onchange="this.value = parseFloat(this.value).toFixed(2);" data-next="fee-next" pattern="[0-9]*" name="fee" max="25000" required placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-center futura-medium mt-5">Enter the amount you would like to pay your
                                    coach, in the box above.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" disabled value="Next" id="fee-next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="date">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">When would you like to train?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Choose the date you would like the
                                    training to commence.</h5>
                                <p class="text-center text-muted futura-medium mt-2">Click the box below, and choose a
                                    date from the calendar within the next three months to begin training.</p>
                                <div class="row justify-content-center">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input id="date" type="date" placeholder="YYYY-MM-DD" data-next="date-next" min="{{\Carbon\Carbon::now()->add('+1 day')->format('Y-m-d')}}" max="{{\Carbon\Carbon::now()->add('+80 days')->format('Y-m-d')}}" required name="starts"
                                                class="form-control form-control-lg futura-bold text-dark text-center d-inline mb-0"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <p class="text-center futura-medium mt-5">Select a date above to commence training on.
                                    The time of training can be selected next.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" disabled value="Next" id="date-next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="time">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">What time would you like your session to start?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Choose the time of day that you would like the training session to begin.</h5>
                                <label for="time" class="text-center text-muted futura-medium mt-2">Click the box below, and enter the time for your session.</label>
                                <div class="row justify-content-center">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input id="time" type="time" data-next="time-next" required name="time"
                                                class="form-control form-control-lg futura-bold text-dark text-center d-inline mb-0"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" disabled value="Next" id="time-next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="location">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Where would you like to train?</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto">
                                <h5 class="h3 futura-bold text-center mt-4">Choose the suburb you would like to train
                                    in.</h5>
                                <p class="text-center text-muted futura-medium mt-2">Start typing your location, and
                                    then choose your suburb from the list that pops up.</p>
                                <div class="form-group">
                                    <input type="text" class="form-control" data-next="location-next" autocorrect="off" maxlength=100
                                    	id="job-location" autocomplete="off" required>
                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">
                                    <input type="hidden" id="locality" name="locality">
                                    <input type="hidden" id="country" name="country">
                                </div>
                                <p class="text-center futura-medium mt-5">Choose a location from the list that your
                                    training will take place.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button class="next action-button btn btn-primary btn-md" disabled value="Next" id="location-next" name="next">Next</button>
                </fieldset>

                <fieldset class="fieldsetStep" data-name="finalise">
                    <div class="modal-header d-block border-0">
                        <h5 class="modal-title h3 futura-bold text-center">Request your session</h5>
                        <button type="button" class="close m-2 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-11 m-auto text-center">
                                <img class="w-75" src="{{asset('img/post-job-finish.svg')}}" alt="Job post finished">
                                <h5 class="h3 futura-bold text-center mt-4">Your session is ready to send to the coach!</h5>
                                <p class="text-center futura-medium mt-2">Just click “Submit” below and your coach
                                    will be notified for you. You can edit and make changes from the job page.</p>
                            </div>
                        </div>
                    </div>
                    <button class="previous action-button btn btn-primary btn-md" value="Back" name="back">Back</button>
                    <button type="submit" class="submit action-button btn btn-primary btn-md">Submit</button>
                </fieldset>

            </form>
        </div>
    </div>
</div>

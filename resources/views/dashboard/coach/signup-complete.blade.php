<input type="hidden" id="coach-link" value="{{route('coaches.show', Auth::user()->coach)}}">
<div class="jumbotron">
    <h1 class="display-3">You're all set!</h1>
    <p class="lead">{{Auth::user()->first_name}}, thanks for setting up a Treiner account with us.</p>
    <hr class="my-2">
    <p>Do you have players training with you already? Invite them to Treiner and make use of our system 
        to simplify the process of setting up sessions with them. Also, bring home 100% of your takings
        from each player when you take cash!</p>
    <p class="lead">
        <form id="coach-leadform">
            <div id="players">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="email" name="email" required class="form-control email" placeholder="Add the player's email address">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2 text-right">
                <a href="#" id="add-player">Add another player</a>
            </div>
            <button type="submit" class="btn btn-primary">Invite your players</button>
        </form>
    </p>
    <hr class="my-2">
    <h2 class="display-4">Now what?</h2>
    @if(!Auth::user()->coach->verified)
    @if(Auth::user()->coach->verification_status == 'denied')
    <h4>Your application to join Treiner has been rejected. If you believe this is in error, please <a
            href="{{route('contact')}}">contact us.</a></h4>
    @else
    <h4>You first need to: </h4>
    <ul>
        @if(!Auth::user()->coach->stripe_token)
        <li>Set up your <a href="{{Auth::user()->coach->stripe_link}}">payment details</a></li>
        @endif
        @if(!Auth::user()->email_verified_at)
        <li>Verify your email address</li>
        @endif
        @if(Auth::user()->coach->verification_status == 'pending')
        <li>Wait for us to check your documents (this may take a few days, we'll get back to you via email when
            it's
            done)</li>
        @endif
    </ul>
    @endif
    @endif
    <a name="home" id="home" class="btn btn-primary" href="{{route('home')}}" role="button">Go to your dashboard</a>
</div>
<div class="jumbotron">
    <h1 class="display-3">You're all set!</h1>
    <p class="lead">{{Auth::user()->first_name}}, thanks for setting up a Treiner account with us.</p>
    <hr class="my-2">
    <p>Know a coach who you think would benefit from Treiner? Invite them below!</p>
    <p class="lead">
        <form id="leadform">
            <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required class="form-control">
            </div>
            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Invite this coach</button>
        </form>
    </p>
    <hr class="my-2">
    <h2 class="display-4">Now what?</h2>
    <p>Now your account is set up, you're able to make full use of Treiner's features. You can: </p>
    <ul>
        <li><a href="#" class="post-job">Request the exact soccer session you want</a></li>
        <li><a href="{{route('coaches.show-cities')}}">Book any of our coaches in your area</a></li>
        <li><a href="{{route('camps.index')}}">View and book our selection of camps</a></li>
    </ul>
    <a name="home" id="home" class="btn btn-primary" href="{{route('home')}}" role="button">Go to your dashboard</a>
</div>
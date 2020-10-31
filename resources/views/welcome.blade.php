@extends('layouts.app', ['plain' => true])
@section('content')
@section('description', 'Find qualified & vetted pro soccer coaches to help you start training & boost your soccer skills on Treiner. Find and book a coaching session in minutes.')
@section('schema')
  @include('schema.welcome')
@endsection
<div class="section1">
    <div class="container">
      <div class="section1-1">
        <h1>Soccer Training.<br>Anytime, Anywhere.</h1>
        <p class="mt-2">
          <span class="mr-2">Find a coach and book a session now.</span>
          <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Get Started!</a>
        </p>
      </div>

      <div class="section1-2">
        <ul>
          <li>
            <a href="{{route('coaches.show-cities')}}">
              <img src="{{asset('img/browse-coaches.svg')}}" alt="An image of a magnifying glass, implying the concept of searching">
            </a>
            <h2>Browse<br>Coaches</h2>
            <p>
              Search through all of our coaches available for training in your area. Sort by the coach's location 
              and find local soccer coaches who suit you. All of our coaches are checked and approved for your convenience.
            </p>
          </li>
          <li>
            @can('create', 'Treiner\JobPost')
            <a class="post-job" href="">
              <img src="{{asset('img/post-job.svg')}}" alt="An image of hands shaking, implying that a deal is being made">
            </a>     
            @else
            <a class="" href="{{route('login')}}">
              <img src="{{asset('img/post-job.svg')}}" alt="An image of hands shaking, implying that a deal is being made">
            </a>
            @endauth
            <h2>Post<br>a Job</h2>
            <p>
              Post a soccer training job that our accredited and approved coaches can bid on. Find the best training
              available from a coach of your choice, at a competitive and fair price.
            </p>
          </li>
          {{--<li>
            <a href="{{route('camps.index')}}">
              <img src="{{asset('img/view-camps.svg')}}" alt="An image of a tent">
            </a>
            <h2>View<br>Camps</h2>
            <p>
              Want some intensive training in an inclusive, social and supportive environment? Browse through our camp
              offerings and see if you would like to enrol today.
            </p>
          </li>--}}
          <li>
            <a href="{{route('virtual-training')}}">
              <img src="{{asset('img/virtual.svg')}}" alt="An image of a video camera">
            </a>
            <h2>Virtual<br>Training</h2>
            <p>
              We're now offering online soccer training sessions from your local soccer coaches, so that you can keep your soccer skills sharp while stuck inside.
            </p>
          </li>
        </ul>
      </div>

      <div class="section1-3">
        <div>
          <iframe width="100%" height="315" src="https://www.youtube.com/embed/yVJ2qrYVth4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div>
          <h2>How Treiner Works</h2>
          <p>
            Treiner is the most convenient way to book an expert, safe and experienced soccer coaching professional
            within your area, budget and availability. Treiner is the only soccer-specific coach booking
            platform
            in Australia and looks to focus on the holistic development of players, offering not only personal soccer
            coaches but also those with expertise in futsal, goalkeeping, position specific training, video analysis, and more.
          </p>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="bg-primary text-white">
    <div class="container">
      <div class="section2" id="subscription">
        @include('layouts.components.messages')
        <h2 class="mb-1">
          <label id="email-label" for="email">Subscribe to our monthly newsletter to receive updates and special offers!</label>
        </h2>
        <form method="POST" action="{{route('newsletter.store')}}">
          @csrf
          <input type="email" aria-labelledby="email-label" required name="email" placeholder="Enter email here">
          <button type="submit" class="btn text-primary">Subscribe</button>
        </form>
      </div>
    </div>
  </div>

  <div class="section3">
    <h2>What Others Say About Us </h2>
    <div id="carouselCaptions" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="content">
            <p>After 3 years of private training with Kogu and few others it brought me from quite a shy player to
              winning best and fairest last season. Private training has increased my technical ability tremendously as
              well as my knowledge of the game and fitness. Its very beneficial and helps improve your game a lot and is
              very highly recommended to any player who wants to take their game to the next level.
            </p>
            <h3 class="text-primary">Junji - U20 NPL Player, Melbourne</h3>
          </div>
        </div>
        <div class="carousel-item">
          <div class="content">
            <p>As a coach, not only does Kogu implement brilliant strategies to overcome opposition on the scoreboard,
                he is by far the best coach i have had in a mental sense. Soccer and Futsal are as mentally
                challenging as they are physical so having that extra edge with a motivating coach is that extra push
                needed to reach that next level in soccering development.
              </p>
              <h3 class="text-primary">Liam Polinsky, Sydney</h3>  
          </div>
        </div>
        <div class="carousel-item">
          <div class="content">
            <p>Private training for me was very helpful. It really excelled my ball skills as the ball 
                was constantly at my feet, it also helped me increase my confidence as I could keep 
                practising and practising until I got things right. Private training was very unique 
                as it was different from normal team training because the whole session was focused on 
                yourself and your individual improvement and development.
              </p>
              <h3 class="text-primary">Nikita - Under 16 NPL Player, Melbourne</h3>  
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" aria-label="Previous slide" href="#carouselCaptions" role="button" data-slide="prev">
        <i class="fas fa-angle-left fa-2x text-primary"></i>
      </a>
      <a class="carousel-control-next" aria-label="Next slide" href="#carouselCaptions" role="button" data-slide="next">
        <i class="fas fa-angle-right fa-2x text-primary"></i>
      </a>
      <ol class="carousel-indicators">
        <li data-target="#carouselCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselCaptions" data-slide-to="1"></li>
        <li data-target="#carouselCaptions" data-slide-to="2"></li>
      </ol>
    </div>
  </div>
@endsection

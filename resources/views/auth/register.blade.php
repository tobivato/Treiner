@extends('layouts.app')
@section('title', 'Register')
@section('content')
@section('description', 'Whether you want to boost your soccer skills or boost your income through coaching, Treiner has got your back. Make an account today.')
<div>
	<h1><span>Sign up as a player or a coach</span></h1>
</div>
<div class="register-types">
	<div id="athlete" class="register-type-athlete" style="position: relative">
		<a href="{{route('register.player')}}"><span>Player</span></a>

		{{-- Pop-up benefit --}}
		<div id="athlete-benefit">
			<div class="card">
				<img src="{{asset('/img/horizontal_lockup.svg')}}" height="50px" class="card-img-top" alt="treiner-logo">
				<div class="close-button">close</div>
				<div class="card-body">
					<h5 class="card-title">Register as Player/Parent</h5>
					<div class="card-text" style="text-align: left">
						<p>
							Are you a player or parent seeking to book a safe, qualified and experienced football coach or provider in your area? With Treiner, we can help you achieve your goals with the click of a button. Our platform can assist you in taking your game to the next level by:
						</p>
						<ul style="list-style: square">
							<li>Providing safe, qualified and experienced football coaches.</li>
							<li>Listing appropriate session pricing for all your individual needs.</li>
							<li>Allowing the ability to request a coach, so we can find you.</li>
							<li>Innovative session types such as futsal, position specific training and video analysis.</li>
							<li>One-on-one sessions, team training or camps and academy experiences.</li>
							<li>Virtual training to keep your football skills sound whilst stuck inside.</li>
						</ul>
						<p>
							Players of all ages and abilities can register your details to join the Treiner world and start scoring or saving goals today!
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="coach" class="register-type-coach" style="position: relative">
		<a href="{{route('register.coach')}}"><span>Coach</span></a>
		
		{{-- Pop-up benefit --}}
		<div id="coach-benefit">
			<div class="card">
				<img src="{{asset('/img/horizontal_lockup.svg')}}" height="50px" class="card-img-top" alt="treiner-logo">
				<div class="close-button">close</div>
				<div class="card-body">
					<h5 class="card-title">Register as Coach</h5>
					<div class="card-text" style="text-align: left">
						<p>
							Join our platform of registered and qualified coaches, with your expertise promoted to new clients searching for private football coaching. As a listed coach on Treiner we provide:
						</p>
						<ul style="list-style: square">
							<li>A personalised profile.</li>
							<li>Free promotion of your credentials through our organic and paid digital marketing campaigns.</li>
							<li>Support with operating your one-on-one sessions, team training, camps and academies.</li>
							<li>New and exciting clients to progress your coaching career.</li>
							<li>Feedback collection from sessions to better improve services.</li>
							<li>Session reminders 24 hours beforehand via email and text message.</li>
							<li>Insurance cover provided by the platform on all sessions.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	const athlete = document.getElementById("athlete");
	const athlete_benefit = document.getElementById("athlete-benefit");
	const coach = document.getElementById("coach");
	const coach_benefit = document.getElementById("coach-benefit");
	const close_button = document.querySelectorAll(".close-button");

	// Check the width of screen for styling
	if (screen.width < 1000) {
		athlete_benefit.style.cssText = "position: absolute; top: 100%; width: 95vw; display:none; z-index: 10; transform: translate(100%, 100%)";
		coach_benefit.style.cssText = "position: absolute; top: 100%; width: 95vw; display:none; z-index: 10; transform: translate(100%, 100%)";
		close_button[0].style.cssText = "position: absolute; top: 2%; right: 90%; display:block";
		close_button[1].style.cssText = "position: absolute; top: 2%; right: 90%; display:block";

		athlete.addEventListener("mouseover", function(){ 
			athlete_benefit.style.display = "block";
			athlete_benefit.style.transform = "translate(0, 0)";
		});

		coach.addEventListener("mouseover", function(){ 
			coach_benefit.style.display = "block";
			coach_benefit.style.transform = "translate(0, 0)";
		});

		athlete.addEventListener("mouseout", function(){ 
			athlete_benefit.style.display = "none";
			athlete_benefit.style.transform = "translate(100%, 100%)";
		});

		coach.addEventListener("mouseout", function(){ 
			coach_benefit.style.display = "none";
			coach_benefit.style.transform = "translate(100%, 100%)";
		});

		athlete_benefit.addEventListener("click", function(){ 
			athlete_benefit.style.display = "none";
			athlete_benefit.style.transform = "translate(100%, 100%)";
		});
		coach_benefit.addEventListener("click", function(){ 
			coach_benefit.style.display = "none";
			coach_benefit.style.transform = "translate(100%, 100%)";
		});

	} else {
		athlete_benefit.style.cssText = "width: 20rem; display:none; position: absolute; top: -10%; right: 80%";
		coach_benefit.style.cssText =  style="width: 20rem; display:none; position: absolute; top: -10%; left: 80%";
		close_button[0].style.cssText = "position: absolute; top: 2%; right: 90%; display:none";
		close_button[1].style.cssText = "position: absolute; top: 2%; right: 90%; display:none";

		athlete.addEventListener("mouseover", function(){ 
			athlete_benefit.style.display = "block";
		});

		coach.addEventListener("mouseover", function(){ 
			coach_benefit.style.display = "block";
		});

		athlete.addEventListener("mouseout", function(){ 
			athlete_benefit.style.display = "none";
		});

		coach.addEventListener("mouseout", function(){ 
			coach_benefit.style.display = "none";
		});
		}
</script>

@endsection
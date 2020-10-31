@component('mail::message')
# Sorry we couldn't find you a session

Hi {{$user->first_name}},<br>

We're sorry we couldn't find a coach for the session that you requested.
If you're still looking for training, please reach out to us through the [contact form]({{route('contact')}}),
and we'll manually find a coach for you.

Best wishes,<br>
Treiner

@endcomponent
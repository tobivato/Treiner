@component('mail::message')
# Add new sessions to your account and get more bookings!

Hi {{$user->first_name}},<br>

We see that you haven't recently added any sessions to your Treiner account. Adding a new session will
increase your potential earnings through Treiner, and make increase the number of players who look at
your profile.
@component('mail::button', ['url' => route('home')])
Create a session 
@endcomponent

Thanks,<br>
Treiner

@slot('subcopy')
You are receiving this email because you have a Treiner coaching account. 
To unsubscribe from these emails, click here: [Unsubscribe]({{$unsub_link}})
@endslot
@endcomponent
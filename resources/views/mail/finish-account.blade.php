@component('mail::message')
# Finish setting up your account and start getting bookings!

Hi {{$user->first_name}},<br>

All you need to do before your account is properly set up and can start getting bookings from 
interested players is add a new coaching session to your profile. This will mean that anybody who searches
for local coaches will be able to see your profile and book your session. The more sessions you add,
the more your profile will be seen!

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
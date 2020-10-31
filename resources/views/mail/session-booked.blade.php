@component('mail::message')
# Your Treiner session has been booked

Hello {{$playerName}},<br>

Congratulations on booking your coaching session with one of our qualified coaches. This email confirms your appointment at {{$sessionPlayers->first()->session->starts->format('h:ia \o\n l \t\h\e jS \o\f F')}} with {{$sessionPlayers->first()->session->coach->user->name}} at {{$sessionPlayers->first()->session->location->address}}. 
If you have any questions or need to make booking changes, please contact us through our various social media platforms and we will be happy to help.
Thank you for booking with us and using our platform.
You can contact the coach through the Messages tab at the top of the site.
We’re excited to have you on board!

___

@component('mail::button', ['url' => route('sessions.index')])
View your sessions
@endcomponent

Thanks,<br>
Treiner
@endcomponent
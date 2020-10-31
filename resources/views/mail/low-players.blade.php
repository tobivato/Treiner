@component('mail::message')
# Not enough players in your session

Hi {{$playerName}},<br>

Unfortunately, your session with {{$session->coach->user->name}} at {{$session->location->address}} at {{$session->starts}}
 doesn't have enough players and is at risk of being cancelled. If 
 {{$session->group_min - count($session->sessionPlayers)}} join within the next two days
  your session will proceed, otherwise it will be cancelled and you'll receive a full refund.

@component('mail::button', ['url' => route('home')])
View your sessions
@endcomponent

Thanks,<br>
Treiner
@endcomponent

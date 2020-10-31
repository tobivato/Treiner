@component('mail::message')
# Your receipt

Hi {{$coachName}},<br>

This is your receipt for your session at {{$session->starts}}.

@foreach ($session->sessionPlayers as $sessionplayer)
{{$sessionplayer->player->user->name}}: {{$session->formattedFeePerPerson}}

@endforeach

Total: {{$session->formattedFee}}

Payment method: {{$paymentMethod}}

@component('mail::button', ['url' => route('welcome')])
View your sessions
@endcomponent

Thanks,<br>
Treiner
@endcomponent


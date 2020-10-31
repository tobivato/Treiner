@component('mail::message')
# Session cancelled due to low attendance

Hi {{$user->name}},<br>

Your session with {{$session->coach->user->email}} on {{$session->starts}} at 
{{$session->location->address}} has unfortunately been cancelled, since the number 
of players that signed up for it was less than what the coach required.

You will be fully refunded.

@component('mail::button', ['url' => route('sessions')])
View your sessions
@endcomponent

Thanks,<br>
Treiner
@endcomponent
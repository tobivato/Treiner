@component('mail::message')
# Session cancelled

Hi {{$playerName}},<br>

Your session with {{$coachName}} on {{$session->starts}} at {{$session->location->address}} has unfortunately been cancelled.
You will be fully refunded.

@component('mail::button', ['url' => route('sessions')])
View your sessions
@endcomponent

Thanks,<br>
Treiner
@endcomponent
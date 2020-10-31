@component('mail::message')
# Player withdrawn

Hi {{$name}},<br>

A player has withdrawn from your {{$type}} session at {{$location}} on {{$starts}}.

@component('mail::button', ['url' => route('home')])
Manage your sessions
@endcomponent

Thanks,<br>
Treiner
@endcomponent
@component('mail::message')
# New booking

Hi {{$coachName}},<br>

You have received a new booking from {{$player->user->name}} for your {{__('coaches.'.$session->type)}} session  at {{$session->location->address}} that starts on {{$session->starts->format('d/m/Y')}} at {{$session->starts->format('h:ia')}}.

You will receive {{$session->formattedFeePerPerson}} on completion.

@component('mail::button', ['url' => route('home')])
View your sessions
@endcomponent

Thanks,<br>
Treiner
@endcomponent
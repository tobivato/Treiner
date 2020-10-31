@component('mail::message')
# A new soccer coaching job near you

Hi {{$user->first_name}},<br>

A new coaching job has been posted near you.

@component('mail::panel')
__{{$job->title}}__

Location: {{$job->location->locality}}

Starts: {{$job->starts->format('h:i a D, jS F Y')}}

Length: {{$job->length}} minutes

Fee: {{$job->formattedFee}}

@component('mail::button', ['url' => route('jobs.show', $job->id)])
Apply
@endcomponent
@endcomponent

Thanks,<br>
Treiner

@endcomponent
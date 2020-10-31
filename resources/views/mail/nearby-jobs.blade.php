@component('mail::message')
# Coaching jobs near you

Hi {{$user->first_name}},<br>

We've found some jobs near you.

@foreach($jobs as $job)
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
@endforeach

Thanks,<br>
Treiner

@endcomponent
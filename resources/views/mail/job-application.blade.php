@component('mail::message')
# A coach has applied to your job!

Hi {{$playerName}},<br>

Your job post, "{{$jobOffer->jobPost->title}}", has received a new application from a coach, {{$jobOffer->coach->user->name}}.

@component('mail::button', ['url' => route('jobs.index')])
View your jobs
@endcomponent

Thanks,<br>
Treiner
@endcomponent
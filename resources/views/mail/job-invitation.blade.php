@component('mail::message')
# A player has invited you for a coaching session

Hi {{$user->first_name}},<br>

A Treiner user has invited you to create a session with them. Log on to your Treiner account and view
the request, then decide whether you'd like to do this kind of session.
You'll have to be fast though, since other coaches can also bid for the job.

@component('mail::button', ['url' => route('jobs.show', $jobInvitation->jobPost)])
View the job
@endcomponent

Thanks,<br>
Treiner
@endcomponent

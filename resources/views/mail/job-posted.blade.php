@component('mail::message')
# Your job has been posted

Hi {{$user->first_name}},<br>

Your session request has been successfully posted and our coaches are now able to connect with you. It won’t be long until your first session is booked!
The platform enables players or parents to easily search, find and book a coach or service provider based on their specific requirements. You are also able to request a specific session and let the coach know what you're looking for. 

Once a coach has accepted a session with you, details will be sent through to both of you straight away. Reminders will also be sent via email and text message 24 hours before the session so both you and your client are clear on the session details. 
Make sure you are keeping your profile page up to date with new information to assist our coaches in the booking process.

We will also be sending you updates in terms of how to fully utilise the Treiner platform including new coaches and features that have been added if you have requested them. 

@component('mail::button', ['url' => route('jobs.index')])
View your job posts
@endcomponent

Thanks,<br>
Treiner
@endcomponent
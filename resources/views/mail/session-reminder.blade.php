@component('mail::message')
# Session Reminder

Hello {{$userName}},<br>

This email is a reminder of your session with one of our Treiner coaches.

# Session Details

Booking for: {{$userName}}

Booked with: {{$session->coach->name}}

Date: {{$session->starts}}

*Session Fees*: Able to be paid on the day if they haven’t been paid online. Please refer to our website if you need more information on payment options.

*Cancellations*: You can reschedule your session with your coach online via our website. Please cancel within 24 hours of your training session as a courtesy to our coaches. Late cancellation/non-attendance policy fees may apply. For more information please re-visit [our privacy policy](https://treiner.co/privacy).

Thanks,<br>
Treiner
@endcomponent
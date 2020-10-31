@component('mail::message')
# Review your session

Hi {{$player}},<br>

Thank you for choosing Treiner!
Please take a minute to review your session with {{$coach}} so that other users can know your thoughts.
@component('mail::button', ['url' => $url])
Add your review
@endcomponent

Thanks,<br>
Treiner
@endcomponent
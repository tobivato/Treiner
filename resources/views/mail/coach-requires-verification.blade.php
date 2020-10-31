@component('mail::message')
# New Coach Needing Verification

There is a new coach waiting to be verified.<br>

@component('mail::button', ['url' => route('verifications.index')])
View verifications
@endcomponent

Thanks,<br>
Treiner
@endcomponent
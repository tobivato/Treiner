@component('mail::message')
# Treiner application denied

Hi {{$user->first_name}},<br>

Your application to join Treiner has been denied for the following reason:

{{$denyReason}}

If you feel that this was in error, please contact us.

Thanks,<br>
Treiner
@endcomponent
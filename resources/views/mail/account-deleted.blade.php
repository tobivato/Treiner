@component('mail::message')
# We’re sorry to see you go

Hello {{$name}},<br/>

We are sending this email just to confirm that your Treiner account has been deleted.

We hope that you begin to use our platform again soon, with many coaches available on Treiner to help you or your child take the next steps in their soccering career.

If you would like to start booking coaches with us again, simply make a new account to continue to use our services.

@component('mail::button', ['url' => route('register')])
Create a new account
@endcomponent

Thanks,<br>
Treiner
@endcomponent
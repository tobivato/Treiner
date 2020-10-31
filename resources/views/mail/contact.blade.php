@component('mail::message')
# Contact

From: {{$name}}, <a href="mailto:{{$email}}">{{$email}}</a>

Message: {{$content}}

@endcomponent
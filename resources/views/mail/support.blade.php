@component('mail::message')
# Support Ticket

User: {{$user->id}}, {{$user->name}}

Title: {{$title}}

Severity: {{$severity}}

Type: {{$type}}

Comments: {{$comments}}

@endcomponent
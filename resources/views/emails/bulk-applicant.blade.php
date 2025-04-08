@component('mail::message')
# {{ $subject }}

Hello {{ $applicant->name }},

{!! nl2br(e($message)) !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent 
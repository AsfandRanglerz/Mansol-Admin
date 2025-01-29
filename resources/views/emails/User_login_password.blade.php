@component('mail::message')


Password: {{ $message['password'] }}

Email: {{ $message['email'] }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent

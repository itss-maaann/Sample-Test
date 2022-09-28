@component('mail::message')
# Hey Mr/Mrs, {{ $details['to']->name }}

{{ $details['title'] }}

{{ $details['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

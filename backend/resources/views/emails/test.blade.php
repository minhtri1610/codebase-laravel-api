<x-mail::message>
# {{ $title }}

Hello there! 

{{ $bodyContent }}

<x-mail::panel>
This is an automated test email sent from the Laravel API.
</x-mail::panel>

<x-mail::button :url="'https://nextjs-app.com'">
Visit our Website
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

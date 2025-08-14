<x-mail::message>
# Account Deletion Request

Hello **{{ $user->first_name }} {{ $user->last_name }}**,

We received a request to delete your account on **{{ config('app.name') }}**.  
Use the verification code below to confirm this action:

<x-mail::panel>
## {{ $code }}
</x-mail::panel>

This code will expire in **5 minutes**.

<x-mail::button :url="config('app.url')">
Go to {{ config('app.name') }}
</x-mail::button>

Thanks,<br>
**{{ config('app.name') }}** Team
</x-mail::message>

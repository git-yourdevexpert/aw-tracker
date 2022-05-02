@component('mail::message')
# Verify E-Mail Address

Dear {{ $user->getFullName() }},

You have successfully registered on the <a href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a> website.

Please verify your email address by clicking on the below button.

@component('mail::button', ['url' => route('pages.register.verifyEmail', $user->verification_token)])
Verify E-Mail address
@endcomponent

Alternatively, you can copy and paste the below link in your browser to verify your email address.

<a href="{{ route('pages.register.verifyEmail', $user->verification_token) }}">{{ route('pages.register.verifyEmail', $user->verification_token) }}</a>

Thanks,<br>
{{ config('app.name') }}

<hr />

<p style="font-size: 12px; font-style: italic;">This is a system generated email. You need not reply to this email.</p>
@endcomponent

@component('mail::message')
    # Reset Your Password

    Dear {{ $record->email }},

    Click the below button to update your password.

    @component('mail::button', ['url' => route('pages.resetPassword', $record->token)])
        Reset Password
    @endcomponent

    Alternatively, you can copy and paste the below link in your browser to update your password.

    <a href="{{ route('pages.resetPassword', $record->token) }}">{{ route('pages.resetPassword', $record->token) }}</a>

    Thanks,<br>
    {{ config('app.name') }}

    <hr />

    <p style="font-size: 12px; font-style: italic;">This is a system generated email. You need not reply to this email.</p>
@endcomponent

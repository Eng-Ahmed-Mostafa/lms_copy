<x-auth-layout
    title="Password Reset"
    subtitle="Password Reset"
>

    <h2 class="greeting">
        Hello {{ $name }},
    </h2>

    <p class="email-text">
        We received a request to reset the password
        associated with your account.
    </p>

    <p class="email-text">
        Click the button below to create a new password:
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">

                <a href="{{ $url }}" class="email-button">
                    Reset My Password
                </a>

            </td>
        </tr>
    </table>

    <div class="security-notice">

        <p class="security-text">
            If you did not request a password reset,
            you can safely ignore this email.
            Your password will remain unchanged.
        </p>

    </div>

    <p class="fallback-text">
        If the button above does not work, copy and paste
        the following link into your browser:
    </p>

    <p class="email-url">
        <a href="{{ $url }}" class="email-link">
            {{ $url }}
        </a>
    </p>

</x-email-layout>

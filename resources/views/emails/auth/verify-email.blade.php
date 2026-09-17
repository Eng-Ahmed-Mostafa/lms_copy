<x-auth-layout
    title="Verify Email"
    subtitle="Verify Your Email Address"
>
    <p class="text-gray-600 text-base mb-6">
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">

                <a href="{{ $url }}" class="email-button">
                    Verify Email Address
                </a>

            </td>
        </tr>
    </table>

</x-email-layout>

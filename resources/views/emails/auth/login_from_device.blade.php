<x-auth-layout
    title="You've Logged in from a New Device"
    subtitle="If this was you, you can safely ignore this email. If not, please revoke access to this device by clicking the button below."
>
    <p class="text-gray-600 text-base mb-6">
        If you did not log in from this device, please click the button below to revoke access.
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">

                <a href="{{ $url }}" class="email-button">
                    Revoke Access
                </a>

            </td>
        </tr>
    </table>

</x-email-layout>

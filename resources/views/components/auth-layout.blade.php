<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7fb;
            font-family: Arial, Helvetica, sans-serif;
            color: #333333;
        }

        .email-wrapper {
            background-color: #f4f7fb;
            padding: 40px 15px;
        }

        .email-container {
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        /* Header */

        .email-header {
            background-color: #2563eb;
            padding: 30px 20px;
        }

        .app-name {
            margin: 0;
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
        }

        .email-subtitle {
            margin: 8px 0 0;
            color: #dbeafe;
            font-size: 14px;
        }

        /* Content */

        .email-content {
            padding: 40px 35px;
        }

        .greeting {
            margin: 0 0 20px;
            font-size: 24px;
            color: #111827;
        }

        .email-text {
            margin: 0 0 18px;
            font-size: 16px;
            line-height: 1.7;
            color: #4b5563;
        }

        /* Button */

        .email-button {
            display: inline-block;
            padding: 14px 30px;
            background-color: #2563eb;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
        }

        /* Security Notice */

        .security-notice {
            margin-top: 30px;
            padding: 18px;
            background-color: #f9fafb;
            border-left: 4px solid #2563eb;
            border-radius: 6px;
        }

        .security-text {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            color: #6b7280;
        }

        /* Links */

        .email-link {
            color: #2563eb;
            text-decoration: none;
        }

        /* Fallback URL */

        .fallback-text {
            margin: 30px 0 8px;
            font-size: 13px;
            color: #6b7280;
        }

        .email-url {
            margin: 0;
            word-break: break-all;
            font-size: 13px;
        }

        /* Footer */

        .email-footer {
            padding: 25px 20px;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            margin: 0 0 8px;
            font-size: 13px;
            color: #6b7280;
        }

        .copyright {
            margin: 0;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">

                <table class="email-container" width="100%" cellpadding="0" cellspacing="0" border="0">

                    {{-- Header --}}
                    <tr>
                        <td align="center" class="email-header">

                            <h1 class="app-name">
                                {{ config('app.name') }}
                            </h1>

                            <p class="email-subtitle">
                                {{ $subtitle ?? 'Account Notification' }}
                            </p>

                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td class="email-content">

                            {{ $slot }}

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" class="email-footer">

                            <p class="footer-text">
                                This email was sent automatically by
                                {{ config('app.name') }}.
                            </p>

                            <p class="copyright">
                                &copy; {{ date('Y') }}
                                {{ config('app.name') }}.
                                All rights reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>

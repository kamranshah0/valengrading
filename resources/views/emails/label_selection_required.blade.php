<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Required: Label Selection</title>
</head>
<body style="font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #ffffff; color: #333333; margin: 0; padding: 0;">
    <!-- Outer wrapper for white bg -->
    <div style="background-color: #ffffff; padding: 20px;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
            
            <!-- Header -->
            <div style="background-color: #15171A; padding: 30px;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="vertical-align: middle; padding-right: 12px;">
                                        <img src="{{ $message->embed(\App\Models\SiteSetting::get('site_logo_header') ? public_path(str_replace(url('/'), '', \App\Models\SiteSetting::get('site_logo_header'))) : public_path('images/logo.avif')) }}" alt="Valen Grading" style="height: 48px; width: auto; object-fit: contain; display: block;">
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <h1 style="margin: 0; font-size: 20px; font-weight: bold; color: #ef4444; font-family: 'Outfit', sans-serif; line-height: 1.2;">
                                            {{ \App\Models\SiteSetting::get('site_name', 'Valen Grading') }}
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div style="padding: 40px 30px;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h2 style="color: #111827; font-size: 24px; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Action Required</h2>
                    <div style="height: 4px; width: 40px; background-color: #A3050A; margin: 15px auto 0; border-radius: 2px;"></div>
                </div>

                <p style="margin-top: 0; font-size: 16px; color: #111827; text-align: center;">Hi <strong>{{ $submission->user->name ?? $submission->shippingAddress->full_name ?? 'Collector' }}</strong>,</p>
                <p style="color: #4B5563; font-size: 15px; text-align: center; margin-bottom: 30px;">Your submission <strong style="color: #A3050A;">#{{ $submission->submission_no }}</strong> requires your attention. Because you used Easy Submission, we kindly ask you to choose your preferred label style for each card so we can continue processing your order.</p>

                <!-- Details Grid -->
                <div style="margin: 25px 0; background-color: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding-bottom: 15px; width: 50%;">
                                <span style="font-weight: bold; color: #6B7280; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 4px;">Service Level</span>
                                <span style="color: #111827; font-weight: 600;">{{ $submission->serviceLevel->name }}</span>
                            </td>
                            <td style="padding-bottom: 15px; width: 50%;">
                                <span style="font-weight: bold; color: #6B7280; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 4px;">Total Cards</span>
                                <span style="color: #111827; font-weight: 600;">{{ $submission->card_entry_mode === 'detailed' ? $submission->cards->sum('qty') : $submission->total_cards }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold; color: #6B7280; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 4px;">Submission Tracker</span>
                                <span style="display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; background-color: #FDF6B2; color: #723B13;">Pending Selection</span>
                            </td>
                            <td>
                                <span style="font-weight: bold; color: #6B7280; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 4px;">Action</span>
                                <span style="color: #A3050A; font-weight: 600;">Label Assignment</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="text-align: center; margin: 40px 0;">
                    <a href="{{ route('user.submissions.labels', $submission->id) }}" style="display: inline-block; padding: 14px 32px; background-color: #A3050A; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px -1px rgba(163,5,10,0.2);">Select Labels Now</a>
                </div>

            </div>

            <div style="text-align: center; padding: 30px 20px; border-top: 1px solid #e5e7eb; background-color: #f3f4f6; color: #9CA3AF; font-size: 12px;">
                <p style="margin: 0 0 5px 0;">&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Valen Grading') }}. All rights reserved.</p>
                <p style="margin: 0;">If you have any questions, please contact us at support@valengrading.com</p>
            </div>
        </div>
    </div>
</body>
</html>

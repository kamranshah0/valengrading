<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ \App\Models\SiteSetting::get('site_name', 'Valen Grading') }}</title>
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
                                    <td style="vertical-align: middle; padding-right: 12px;">
                                        @php
                                            $logoPath = \App\Models\SiteSetting::get('site_logo_header');
                                            $embedPath = $logoPath ? public_path(str_replace(url('/'), '', $logoPath)) : public_path('images/logo.avif');
                                        @endphp
                                        @if(file_exists($embedPath) && !is_dir($embedPath))
                                            <img src="{{ $message->embed($embedPath) }}" alt="{{ \App\Models\SiteSetting::get('site_name', 'Valen Grading') }}" style="height: 48px; width: auto; object-fit: contain; display: block;">
                                        @else
                                            <img src="{{ asset('images/logo.avif') }}" alt="{{ \App\Models\SiteSetting::get('site_name', 'Valen Grading') }}" style="height: 48px; width: auto; object-fit: contain; display: block;">
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <h1 style="margin: 0; font-size: 28px; font-weight: 800; color: #ef4444; font-family: 'Outfit', sans-serif; line-height: 1.2; letter-spacing: -0.5px;">
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
                    <h2 style="color: #111827; font-size: 24px; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Welcome to the Registry</h2>
                    <div style="height: 4px; width: 40px; background-color: #A3050A; margin: 15px auto 0; border-radius: 2px;"></div>
                </div>

                <p style="margin-top: 0; font-size: 16px; color: #111827; text-align: center;">Hi <strong>{{ $user->name }}</strong>,</p>
                
                <p style="color: #4B5563; font-size: 15px; text-align: center; margin-bottom: 30px; line-height: 1.6;">
                    Thank you for joining <strong>{{ \App\Models\SiteSetting::get('site_name', 'Valen Grading') }}</strong>. We are thrilled to welcome you to our community of collectors and enthusiasts.
                </p>

                <p style="color: #4B5563; font-size: 15px; text-align: center; margin-bottom: 30px; line-height: 1.6;">
                    Your account has been successfully created. You can now log in to manage your collection, submit cards for premium grading, and track your ongoing submissions all from your user dashboard.
                </p>

                <div style="text-align: center; margin: 40px 0;">
                    <a href="{{ route('login') }}" style="display: inline-block; padding: 14px 32px; background-color: #A3050A; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px -1px rgba(163,5,10,0.2);">Access Your Dashboard</a>
                </div>

                <h3 style="color: #111827; margin-top: 30px; font-size: 18px; text-align: center;">What's Next?</h3>
                <ul style="font-size: 15px; color: #4B5563; margin-bottom: 30px; padding-left: 20px; line-height: 1.6; max-width: 400px; margin-left: auto; margin-right: auto; text-align: left;">
                    <li style="margin-bottom: 8px;">Explore our grading services and pricing.</li>
                    <li style="margin-bottom: 8px;">Submit your first card for verification.</li>
                    <li>Update your profile and shipping details.</li>
                </ul>
            </div>

            <!-- Footer -->
            <div style="text-align: center; padding: 30px 20px; border-top: 1px solid #e5e7eb; background-color: #f3f4f6; color: #9CA3AF; font-size: 12px;">
                <p style="margin: 0 0 5px 0;">&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Valen Grading') }}. All rights reserved.</p>
                <p style="margin: 0;">If you have any questions, please contact us at support@valengrading.com</p>
            </div>
        </div>
    </div>
</body>
</html>

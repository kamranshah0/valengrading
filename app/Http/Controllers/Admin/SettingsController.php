<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'admin_notification_email' => SiteSetting::get('admin_notification_email', 'admin@valengrading.com'),
            'site_name' => SiteSetting::get('site_name', 'Valen Grading'),
            'site_logo_header' => SiteSetting::get('site_logo_header', asset('images/logo.avif')),
            'site_logo_footer' => SiteSetting::get('site_logo_footer', asset('images/logo.avif')),
            'return_shipping_fee' => SiteSetting::get('return_shipping_fee', '7.99'),
            
            // SMTP Settings
            'mail_host' => SiteSetting::get('mail_host', 'smtp.mailtrap.io'),
            'mail_port' => SiteSetting::get('mail_port', '2525'),
            'mail_username' => SiteSetting::get('mail_username', ''),
            'mail_password' => SiteSetting::get('mail_password', ''),
            'mail_encryption' => SiteSetting::get('mail_encryption', 'tls'),
            'mail_from_address' => SiteSetting::get('mail_from_address', 'hello@valengrading.com'),
            'mail_from_name' => SiteSetting::get('mail_from_name', 'Valen Grading'),



            // Shipping Settings
            'shipping_name' => SiteSetting::get('shipping_name', 'Valen Grading'),
            'shipping_address' => SiteSetting::get('shipping_address', ''),
            'shipping_city' => SiteSetting::get('shipping_city', ''),
            'shipping_state' => SiteSetting::get('shipping_state', ''),
            'shipping_zip' => SiteSetting::get('shipping_zip', ''),
            'shipping_country' => SiteSetting::get('shipping_country', 'United Kingdom'),
            'shipping_phone' => SiteSetting::get('shipping_phone', ''),

            // Frontend Content
            'home_hero_title' => SiteSetting::get('home_hero_title', 'Precision Card'),
            'home_hero_subtitle' => SiteSetting::get('home_hero_subtitle', 'Premium UK-based card grading <br> for collectors who demand excellence.'),
            'home_features_title' => SiteSetting::get('home_features_title', 'Very Fast Turnaround'),
            'pricing_title' => SiteSetting::get('pricing_title', 'Label Options'),
            'pricing_subtitle' => SiteSetting::get('pricing_subtitle', 'Choose your preferred label design and service level'),
            'pricing_comparison_title' => SiteSetting::get('pricing_comparison_title', 'Feature Comparison'),
            'pricing_comparison_subtitle' => SiteSetting::get('pricing_comparison_subtitle', "See what's included with each service tier"),
        ];


        return view('admin.settings.index', $settings);
    }

    public function updateGeneral(Request $request)
    {
        $data = $request->validate([
            'admin_notification_email' => 'required|email',
            'site_name' => 'required|string|max:255',
            'site_logo_header' => 'nullable|image|mimes:jpeg,png,jpg,svg,avif|max:4096',
            'site_logo_footer' => 'nullable|image|mimes:jpeg,png,jpg,svg,avif|max:4096',
            'return_shipping_fee' => 'required|numeric|min:0',
        ]);

        $logoTypes = ['site_logo_header', 'site_logo_footer'];
        
        foreach ($logoTypes as $type) {
            if ($request->hasFile($type)) {
                // Delete old logo
                $oldLogo = SiteSetting::get($type);
                if ($oldLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists(str_replace('/storage/', '', $oldLogo))) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $oldLogo));
                }

                $path = $request->file($type)->store('branding', 'public');
                $data[$type] = '/storage/' . $path;
            } else {
                unset($data[$type]);
            }
        }

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value, 'general');
        }

        return back()->with('success', 'General branding and configuration updated.');
    }

    public function updateSMTP(Request $request)
    {
        $data = $request->validate([
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'nullable',
            'mail_password' => 'nullable',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required',

        ]);

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value, 'smtp');
        }

        return back()->with('success', 'SMTP settings updated successfully.');
    }

    public function updateShipping(Request $request)
    {
        $data = $request->validate([
            'shipping_name' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'nullable',
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value, 'shipping');
        }

        return back()->with('success', 'Shipping address updated successfully.');
    }

    public function updateContent(Request $request)
    {
        $data = $request->validate([
            'home_hero_title' => 'required|string',
            'home_hero_subtitle' => 'required|string',
            'home_features_title' => 'nullable|string',
            'pricing_title' => 'nullable|string',
            'pricing_subtitle' => 'nullable|string',
            'pricing_comparison_title' => 'nullable|string',
            'pricing_comparison_subtitle' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value, 'content');
        }

        return back()->with('success', 'Frontend content updated successfully.');
    }



    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->fill($request->all());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('success', 'Profile information updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.current_password' => 'The provided password does not match our records.'
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}

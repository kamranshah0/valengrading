<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'home_hero_title' => 'Precision Card',
            'home_hero_subtitle' => 'Premium UK-based card grading <br> for collectors who demand excellence.',
            'home_features_title' => 'Very Fast Turnaround',
            'pricing_title' => 'Label Options',
            'pricing_subtitle' => 'Choose your preferred label design and service level',
            'pricing_comparison_title' => 'Feature Comparison',
            'pricing_comparison_subtitle' => "See what's included with each service tier",
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::set($key, $value, 'content');
        }
    }
}

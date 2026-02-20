<?php

namespace Database\Seeders;

use App\Models\ServiceLevel;
use Illuminate\Database\Seeder;

class ServiceLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing levels to remove Elite/Standard etc.
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\ServiceLevel::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get Submission Types
        $grading = \App\Models\SubmissionType::where('name', 'Grading')->first();
        $reholder = \App\Models\SubmissionType::where('name', 'Reholder')->first();
        $crossover = \App\Models\SubmissionType::where('name', 'Crossover')->first();
        $auth = \App\Models\SubmissionType::where('name', 'Authentication')->first();

        $tiers = [
            ['name' => 'Basic', 'time' => '45 Business Days', 'price' => 15.00],
            ['name' => 'Express', 'time' => '20 Business Days', 'price' => 25.00],
            ['name' => 'Premium', 'time' => '5 Business Days', 'price' => 45.00],
        ];

        // 1. Grading
        if ($grading) {
            foreach ($tiers as $index => $tier) {
                ServiceLevel::create([
                    'submission_type_id' => $grading->id,
                    'name' => $tier['name'],
                    'delivery_time' => $tier['time'],
                    'min_submission' => $tier['name'] === 'Basic' ? 5 : null,
                    'price_per_card' => $tier['price'],
                    'order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        // 2. Reholder
        if ($reholder) {
            foreach ($tiers as $index => $tier) {
                ServiceLevel::create([
                    'submission_type_id' => $reholder->id,
                    'name' => $tier['name'] . ' Reholder',
                    'delivery_time' => $tier['time'],
                    'min_submission' => null,
                    'price_per_card' => $tier['price'],
                    'order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        // 3. Crossover
        if ($crossover) {
            foreach ($tiers as $index => $tier) {
                ServiceLevel::create([
                    'submission_type_id' => $crossover->id,
                    'name' => $tier['name'] . ' Crossover',
                    'delivery_time' => $tier['time'],
                    'min_submission' => null,
                    'price_per_card' => $tier['price'],
                    'order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        // 4. Authentication
        if ($auth) {
            foreach ($tiers as $index => $tier) {
                ServiceLevel::create([
                    'submission_type_id' => $auth->id,
                    'name' => $tier['name'] . ' Authentication',
                    'delivery_time' => $tier['time'],
                    'min_submission' => null,
                    'price_per_card' => $tier['price'],
                    'order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}

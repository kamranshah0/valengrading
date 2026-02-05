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

        // 1. Grading (Basic: £8, Express: £15? - Keeping placeholder)
        if ($grading) {
            ServiceLevel::create([
                'submission_type_id' => $grading->id,
                'name' => 'Basic',
                'delivery_time' => '15-20 Business Days',
                'min_submission' => 5,
                'price_per_card' => 8.00,
                'order' => 1,
                'is_active' => true,
            ]);
            ServiceLevel::create([
                'submission_type_id' => $grading->id,
                'name' => 'Express',
                'delivery_time' => '5-7 Business Days',
                'min_submission' => 5,
                'price_per_card' => 15.00, // Placeholder
                'order' => 2,
                'is_active' => true,
            ]);
        }

        // 2. Reholder (£6, No Min)
        if ($reholder) {
            ServiceLevel::create([
                'submission_type_id' => $reholder->id,
                'name' => 'Standard Reholder',
                'delivery_time' => '10-15 Business Days',
                'min_submission' => null,
                'price_per_card' => 6.00,
                'order' => 1,
                'is_active' => true,
            ]);
        }

        // 3. Crossover (£6, No Min)
        if ($crossover) {
            ServiceLevel::create([
                'submission_type_id' => $crossover->id,
                'name' => 'Standard Crossover',
                'delivery_time' => '15-20 Business Days',
                'min_submission' => null,
                'price_per_card' => 6.00,
                'order' => 1,
                'is_active' => true,
            ]);
        }

        // 4. Authentication (£6, Min 2)
        if ($auth) {
            ServiceLevel::create([
                'submission_type_id' => $auth->id,
                'name' => 'Authentication Only',
                'delivery_time' => '15-20 Business Days',
                'min_submission' => 2,
                'price_per_card' => 6.00,
                'order' => 1,
                'is_active' => true,
            ]);
        }
    }
}

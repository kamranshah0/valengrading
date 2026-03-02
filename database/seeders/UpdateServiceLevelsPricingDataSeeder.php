<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateServiceLevelsPricingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiers = [
            'Basic' => ['time' => '45 Business Days', 'subtitle' => 'Perfect for casual collectors', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'],
            'Express' => ['time' => '20 Business Days', 'subtitle' => 'Faster service for urgent needs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>'],
            'Premium' => ['time' => '5 Business Days', 'subtitle' => 'Our highest tier service', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>'],
        ];

        $services = [
            'grading' => [
                'Basic' => ['Authentication', 'Expert Grading', 'Encapsulation', 'Basic insurance'],
                'Express' => ['All Basic features', 'Priority handling', 'Enhanced insurance', 'Front of line access'],
                'Premium' => ['All Express features', 'Same day processing', 'Dedicated support', 'Max insurance cover', 'White glove service'],
            ],
            'crossover' => [
                'Basic' => ['Evaluation', 'New encapsulation if grade meets/exceeds', 'Database entry', 'Basic insurance'],
                'Express' => ['Priority Evaluation', 'New encapsulation if grade meets/exceeds', 'Enhanced insurance', 'Front of line access'],
                'Premium' => ['Expert Panel Evaluation', 'Same day processing', 'Dedicated support', 'Max insurance cover'],
            ],
            'reholder' => [
                'Basic' => ['New Generation Slab', 'Label refresh', 'Sonic sealing'],
                'Express' => ['Priority queue', 'New Generation Slab', 'Enhanced protection'],
                'Premium' => ['Max Speed', 'UV Protection', 'Custom label option'],
            ],
            'authentication' => [
                'Basic' => ['Visual inspection', 'Digital Proof', 'Database addition'],
                'Express' => ['Priority review', 'Physical Letter', 'Fast tracking'],
                'Premium' => ['Multi-expert panel', 'Detailed Report', 'High value items'],
            ]
        ];

        foreach ($services as $serviceKey => $serviceTiers) {
            // Find submission type by slug/lowercased name
            $submissionType = \App\Models\SubmissionType::whereRaw('LOWER(name) = ?', [$serviceKey])->first();
            
            if ($submissionType) {
                foreach ($serviceTiers as $tierName => $features) {
                    $serviceLevel = \App\Models\ServiceLevel::where('submission_type_id', $submissionType->id)
                                        ->where('name', $tierName)
                                        ->first();
                                        
                    if ($serviceLevel && isset($tiers[$tierName])) {
                        $serviceLevel->update([
                            'subtitle' => $tiers[$tierName]['subtitle'],
                            'turnaround_time' => $tiers[$tierName]['time'],
                            'icon' => $tiers[$tierName]['icon'],
                            'features' => $features,
                        ]);
                    }
                }
            }
        }
    }
}

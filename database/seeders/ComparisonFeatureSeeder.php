<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComparisonFeature;

class ComparisonFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['name' => 'Industry-Leading AI', 'is_standard' => true, 'is_express' => true, 'is_elite' => true, 'order' => 1],
            ['name' => 'Tamper-Evident Slab', 'is_standard' => true, 'is_express' => true, 'is_elite' => true, 'order' => 2],
            ['name' => 'Digital Certificates', 'is_standard' => true, 'is_express' => true, 'is_elite' => true, 'order' => 3],
            ['name' => 'Online Registry', 'is_standard' => true, 'is_express' => true, 'is_elite' => true, 'order' => 4],
            ['name' => 'Priority Processing', 'is_standard' => false, 'is_express' => true, 'is_elite' => true, 'order' => 5],
            ['name' => 'High-Res Imaging', 'is_standard' => false, 'is_express' => true, 'is_elite' => true, 'order' => 6],
            ['name' => 'High-Value Insurance', 'is_standard' => false, 'is_express' => true, 'is_elite' => true, 'order' => 7],
            ['name' => 'Same-Day Turnaround', 'is_standard' => false, 'is_express' => false, 'is_elite' => true, 'order' => 8],
            ['name' => 'Dedicated AM', 'is_standard' => false, 'is_express' => false, 'is_elite' => true, 'order' => 9],
            ['name' => 'Personal Account Manager', 'is_standard' => false, 'is_express' => false, 'is_elite' => true, 'order' => 10],
            ['name' => 'White Glove Service', 'is_standard' => false, 'is_express' => false, 'is_elite' => true, 'order' => 11],
        ];

        foreach ($features as $feature) {
            ComparisonFeature::create($feature);
        }
    }
}

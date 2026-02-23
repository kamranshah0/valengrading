<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LabelType;

// Fetch all and delete existing to ensure clean state, or just update the specific ones?
// First let's just create/update the required ones.
LabelType::truncate();

LabelType::create([
    'name' => 'Classic',
    'price_adjustment' => 0.00,
    'description' => 'Classic black and red label',
    'is_active' => true,
    'order' => 1
]);

LabelType::create([
    'name' => 'Spectrum',
    'price_adjustment' => 5.00,
    'description' => 'Colorful spectrum label',
    'is_active' => true,
    'order' => 2
]);

LabelType::create([
    'name' => 'Blackout',
    'price_adjustment' => 15.00,
    'description' => 'Premium blackout label',
    'is_active' => true,
    'order' => 3
]);

echo "Labels updated successfully.\n";

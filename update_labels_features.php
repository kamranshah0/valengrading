<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LabelType;

$classic = LabelType::where('name', 'Classic')->first();
if ($classic) {
    $classic->update([
        'subtitle' => 'Included with submission price',
        'description' => 'Traditional design offering a clean, timeless look for any collection.',
        'features' => ['Clean, timeless design', 'Clear Information', 'QR Code Authentication']
    ]);
}

$spectrum = LabelType::where('name', 'Spectrum')->first();
if ($spectrum) {
    $spectrum->update([
        'subtitle' => 'Enhanced features & security',
        'description' => 'Color matches the card with enhanced security and premium aesthetics.',
        'features' => ['Color matches the card', 'Premium foil text', 'Superior security']
    ]);
}

$blackout = LabelType::where('name', 'Blackout')->first();
if ($blackout) {
    $blackout->update([
        'subtitle' => 'Fully customized design',
        'description' => 'Fully bespoke premium designs for rare, special edition, or personal cards.',
        'features' => ['Ultra-premium blackout styling', 'Exclusive designs', 'All premium features']
    ]);
}

echo "LabelType data structured properly with features arrays.\n";

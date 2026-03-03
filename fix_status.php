<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$updated = \App\Models\SubmissionCard::where('status', 'Cards Received')->update(['status' => 'Cards Logged']);
echo "Updated $updated cards.\n";

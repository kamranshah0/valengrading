<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update old statuses to new workflow
        DB::table('submissions')
            ->where('status', 'order_received')
            ->update(['status' => 'awaiting_arrival']);

        DB::table('submissions')
            ->where('status', 'processing')
            ->update(['status' => 'in_production']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert new statuses to old workflow (best effort)
        DB::table('submissions')
            ->where('status', 'awaiting_arrival')
            ->update(['status' => 'order_received']);

        DB::table('submissions')
            ->where('status', 'in_production')
            ->update(['status' => 'processing']);
    }
};

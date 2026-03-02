<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // "Draft" remains "draft"
        
        // Map old payment-related to new "pending_payment"
        DB::table('submissions')
            ->whereIn('status', ['Submission Complete', 'Cards Logged', 'Awaiting Label Selection', 'Label Selection Received'])
            ->update(['status' => 'pending_payment']);

        // Awaiting Arrival
        DB::table('submissions')
            ->where('status', 'awaiting_arrival')
            ->update(['status' => 'awaiting_arrival']); // No change needed if lowercase

        // Map Grading/Encapsulation to In Production
        DB::table('submissions')
            ->whereIn('status', ['Grading Complete', 'Label Created', 'Encapsulation Complete', 'Quality Control Complete', 'in_production'])
            ->update(['status' => 'in_production']);
            
        // Map old cancelled
        DB::table('submissions')
            ->where('status', 'Cancelled')
            ->update(['status' => 'cancelled']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert not easily deterministic, so we leave it or make best effort.
    }
};

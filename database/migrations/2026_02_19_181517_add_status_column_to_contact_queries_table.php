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
        Schema::table('contact_queries', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_queries', 'status')) {
                $table->string('status')->default('new')->after('is_read');
            }
        });

        // Migrate existing data (safe to run again)
        \DB::table('contact_queries')->where('is_read', true)->where('status', 'new')->update(['status' => 'read']);
        \DB::table('contact_queries')->where('is_read', false)->where('status', 'new')->update(['status' => 'new']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_queries', function (Blueprint $table) {
             if (Schema::hasColumn('contact_queries', 'status')) {
                $table->dropColumn('status');
             }
        });
    }
};

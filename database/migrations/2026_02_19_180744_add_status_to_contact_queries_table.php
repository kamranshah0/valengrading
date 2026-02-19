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
            $table->string('status')->default('new')->after('is_read');
        });

        // Migrate existing data
        \DB::table('contact_queries')->where('is_read', true)->update(['status' => 'read']);
        \DB::table('contact_queries')->where('is_read', false)->update(['status' => 'new']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_queries', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

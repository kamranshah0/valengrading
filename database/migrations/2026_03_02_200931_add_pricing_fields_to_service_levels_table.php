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
        Schema::table('service_levels', function (Blueprint $table) {
            $table->string('subtitle')->nullable();
            $table->string('turnaround_time')->nullable();
            $table->json('features')->nullable();
            $table->text('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_levels', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'turnaround_time', 'features', 'icon']);
        });
    }
};

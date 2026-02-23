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
        Schema::table('label_types', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('name');
            $table->string('image_path')->nullable()->after('description');
            $table->json('features')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('label_types', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'image_path', 'features']);
        });
    }
};

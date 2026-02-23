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
        Schema::table('submission_cards', function (Blueprint $table) {
            $table->integer('centering')->nullable()->change();
            $table->integer('corners')->nullable()->change();
            $table->integer('edges')->nullable()->change();
            $table->integer('surface')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_cards', function (Blueprint $table) {
            $table->decimal('centering', 3, 1)->nullable()->change();
            $table->decimal('corners', 3, 1)->nullable()->change();
            $table->decimal('edges', 3, 1)->nullable()->change();
            $table->decimal('surface', 3, 1)->nullable()->change();
        });
    }
};

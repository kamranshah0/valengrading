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
        Schema::create('comparison_features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_standard')->default(false);
            $table->boolean('is_express')->default(false);
            $table->boolean('is_elite')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comparison_features');
    }
};

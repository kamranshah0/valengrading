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
            if (!Schema::hasColumn('submission_cards', 'brand')) {
                $table->string('brand')->nullable()->after('qty');
            }
            if (!Schema::hasColumn('submission_cards', 'variant')) {
                $table->string('variant')->nullable()->after('card_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_cards', function (Blueprint $table) {
            $table->dropColumn(['brand', 'variant']);
        });
    }
};

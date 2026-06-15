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
        Schema::table('notes', function (Blueprint $table) {
            $table->decimal('lot', 5, 2)->nullable();
            $table->integer('pips')->default(0);
            $table->decimal('profit_loss', 10, 2)->default(0.00);
        });
    }
    
/**
 * Reverse the migrations.
 */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['lot', 'pips', 'profit_loss']);
        });
    }
};

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
        Schema::table('reservations', function (Blueprint $table) {
            $table->decimal('down_payment_amount', 10, 2)->nullable();
            $table->enum('down_payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->decimal('final_payment_amount', 10, 2)->nullable();
            $table->enum('final_payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamp('returned_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['down_payment_amount', 'down_payment_status', 'final_payment_amount', 'final_payment_status', 'returned_at']);
        });
    }
};

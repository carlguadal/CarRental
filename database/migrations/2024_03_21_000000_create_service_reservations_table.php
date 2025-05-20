<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->dateTime('scheduled_date');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_reservations');
    }
}; 
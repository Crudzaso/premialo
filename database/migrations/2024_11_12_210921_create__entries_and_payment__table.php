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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained('raffles');
            $table->foreignId('player_id')->constrained('users');
            $table->string('ticket_number');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('users');
            $table->foreignId('raffle_id')->constrained('raffles');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer', 'other']);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamp('payment_date')->useCurrent();
            $table->timestamp('fecha_liberacion')->nullable();
            $table->string('id_transaccion')->nullable();
            $table->text('evidencia_entrega')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
        Schema::dropIfExists('payments');
    }
};

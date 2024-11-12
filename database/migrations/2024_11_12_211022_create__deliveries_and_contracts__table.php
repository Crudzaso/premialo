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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained('raffles');
            $table->foreignId('winner_id')->constrained('users');
            $table->foreignId('prize_id')->constrained('prizes');
            $table->timestamp('delivery_date')->nullable();
            $table->enum('delivery_status', ['pending', 'delivered', 'failed'])->default('pending');
            $table->string('tracking_number')->nullable();
            $table->text('delivery_notes')->nullable();
            $table->text('code_confirm')->nullable();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained('raffles');
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('prizes_id')->constrained('prizes');
            $table->string('contract_file')->nullable();
            $table->timestamp('signed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('contracts');
    }
};

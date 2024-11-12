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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('action', ['create_raffle', 'purchase_ticket', 'payment', 'draw_winner', 'prize_delivery', 'cancel_raffle', 'edit_raffle', 'user_update', 'user_delete', 'user_create','entry_create', 'entry_update', 'entry_delete', 'error'])->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_audit_logs_');
    }
};

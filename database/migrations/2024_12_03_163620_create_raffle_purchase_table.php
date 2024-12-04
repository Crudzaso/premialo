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
        Schema::create('raffle_purchase', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raffle_id');
            $table->unsignedBigInteger('purchase_id');
            $table->timestamps();

            $table->foreign('raffle_id')->references('id')->on('raffles')->onDelete('cascade');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_purchase');
    }
};

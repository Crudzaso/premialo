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
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('prize_value', 10, 2)->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->timestamp('drawing_date')->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained('raffles');
            $table->enum('prize_type', ['car', 'cash', 'gift', 'service', 'other']);
            $table->text('prize_description')->nullable();
            $table->enum('condition', ['new', 'used', 'refurbished', 'other'])->default('new');
            $table->decimal('prize_value', 10, 2);
            $table->string('photo')->nullable();
            $table->text('delivery_terms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffles');
        schema::dropIfExists('prizes');
    }
};

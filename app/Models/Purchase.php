<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['amount_total', 'purchase_date', 'payment_status'];

    // Relación inversa 1:M con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación M:N con Raffle
    public function raffles()
    {
        return $this->belongsToMany(Raffle::class, 'raffle_purchase', 'purchase_id', 'raffle_id')->withTimestamps();
    }
}


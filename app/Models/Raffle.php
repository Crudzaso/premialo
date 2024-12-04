<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;

    protected $fillable = ['name',
    'description',
    'image_url',
    'amount_raffle',
    'ticket_price',
    'total_tickets',
    'sold_tickets',
    'start_date',
    'end_date',
    'status',
    'photo_winner'
        ];

    // Relación inversa 1:M con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación M:N con Purchase
    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'raffle_purchase', 'raffle_id', 'purchase_id')->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raffles extends Model implements Auditable
{
    use HasFactory, Notifiable, HasRoles;
    use SoftDeletes;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'game_date',
        'status',
        'quantity_numbers',
    ];
}

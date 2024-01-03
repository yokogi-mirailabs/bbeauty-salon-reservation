<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'reservation_id',
        'payjp_card_id',
        'payjp_charge_id',
        'payment_date',
        'payment_amount',
        'payment_result',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'reservation_id' => 'integer',
        'payjp_card_id' => 'string',
        'payjp_charge_id' => 'string',
        'payment_date' => 'datetime',
        'payment_amount' => 'integer',
        'payment_result' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}

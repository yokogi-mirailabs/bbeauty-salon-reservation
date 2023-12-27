<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'name',
        'address',
        'tel',
        'email',
        'description',
    ];

    protected $casts = [
        'admin_id' => 'integer',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function stylists()
    {
        return $this->hasMany(Stylist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function pointCards()
    {
        return $this->hasMany(PointCard::class);
    }
}

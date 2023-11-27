<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\JobPostType;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stylist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'job_post',
        'speciality',
        'working_year'
    ];

    protected $casts = [
        'shop_id' => 'integer',
        'job_post' => JobPostType::class,
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}

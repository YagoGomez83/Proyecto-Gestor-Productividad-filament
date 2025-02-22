<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Camera extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'identifier',
        'location_id',
        'city_id',
        'police_station_id',

    ];

    public function policeStation(): BelongsTo
    {
        return $this->belongsTo(PoliceStation::class, 'police_station_id');
    }


    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function cameras(): HasMany
    {
        return $this->hasMany(Camera::class);
    }
}

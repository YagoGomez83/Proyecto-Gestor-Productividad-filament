<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'regional_unit_id'];

    /**
     * Relación: Una ciudad pertenece a una unidad regional.
     */
    public function regionalUnit(): BelongsTo
    {
        return $this->belongsTo(RegionalUnit::class);
    }

    public function policeStations(): HasMany
    {
        return $this->hasMany(PoliceStation::class);
    }

    public function cameras(): HasMany
    {
        return $this->hasMany(Camera::class);
    }
}

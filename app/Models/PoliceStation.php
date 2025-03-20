<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class PoliceStation extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'city_id'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function cameras(): HasMany
    {
        return $this->hasMany(Camera::class);
    }
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
    public function causes(): HasManyThrough
    {
        return $this->hasManyThrough(
            Cause::class, // El modelo que queremos acceder
            Report::class, // El modelo intermedio
            'police_station_id', // Clave foránea en el modelo intermedio (Report)
            'id', // Clave primaria en el modelo final (Cause)
            'id', // Clave primaria en el modelo principal (PoliceStation)
            'cause_id' // Clave foránea en el modelo final (Cause)
        );
    }

    public function sismoRegisters(): HasMany
    {
        return $this->hasMany(SismoRegister::class);
    }
    public function aplicationForAdmissions(): HasMany
    {
        return $this->hasMany(ApplicationForAdmission::class);
    }
}

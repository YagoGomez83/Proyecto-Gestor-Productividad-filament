<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoliceMovementCode extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'police_movement_codes';

    protected $fillable = [
        'code',
        'description',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Relación con servicios donde este código es el inicial
    public function servicesAsInitial()
    {
        return $this->hasMany(Service::class, 'initial_police_movement_code_id');
    }

    // Relación con servicios donde este código es el final
    public function servicesAsFinal()
    {
        return $this->hasMany(Service::class, 'final_police_movement_code_id');
    }

    public function subPoliceMovementCodes()
    {
        return $this->hasMany(SubPoliceMovementCode::class);
    }
}

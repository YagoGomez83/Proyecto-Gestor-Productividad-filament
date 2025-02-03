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

    public function subPoliceMovementCodes()
    {
        return $this->hasMany(SubPoliceMovementCode::class);
    }
}

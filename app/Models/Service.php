<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'service_date',
        'service_time',
        'user_id',
        'group_id',
        'city_id',
        'initial_police_movement_code_id',
        'final_police_movement_code_id',
        'status',
        'description'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function initialPoliceMovementCode()
    {
        return $this->belongsTo(PoliceMovementCode::class, 'initial_police_movement_code_id');
    }

    public function finalPoliceMovementCode()
    {
        return $this->belongsTo(PoliceMovementCode::class, 'final_police_movement_code_id');
    }
}

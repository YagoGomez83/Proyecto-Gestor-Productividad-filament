<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPoliceMovementCode extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'sub_police_movement_codes';
    protected $fillable = [
        'description',
        'police_movement_code_id',
    ];

    public function policeMovementCode()
    {
        return $this->belongsTo(PoliceMovementCode::class);
    }
}

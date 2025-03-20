<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeasibilityRequest extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'Success',
        'Feasibility_request',
        'Requests_report',
        'Device_assignment',
        'Reports_end_of_monitoring',
        'sismo_register_id',
        'Description'

    ];

    public function sismoRegister(): BelongsTo
    {
        return $this->belongsTo(SismoRegister::class);
    }
}

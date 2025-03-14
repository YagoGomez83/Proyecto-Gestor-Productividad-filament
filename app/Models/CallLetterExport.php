<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallLetterExport extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'event_number',
        'start_datetime',
        'end_datetime',
        'success',
        'description',
        'sismo_register_id',


    ];

    public function sismoRegister(): BelongsTo
    {
        return $this->belongsTo(SismoRegister::class);
    }
}

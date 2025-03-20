<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialReportRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['report_id', 'sismo_register_id', 'success', 'description'];
    //
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
    public function sismoRegister(): BelongsTo
    {
        return $this->belongsTo(SismoRegister::class);
    }
}

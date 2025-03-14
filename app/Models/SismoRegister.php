<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SismoRegister extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_solicitude',
        'solicitud_number',
        'solicitude_type_id',
        'description',
        'cause_id',
        'center_id',
        'police_station_id'
    ];

    public function solicitudeType(): BelongsTo
    {
        return $this->belongsTo(SolicitudeType::class);
    }

    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function policeStation(): BelongsTo
    {
        return $this->belongsTo(PoliceStation::class);
    }

    public function cameraExport(): HasOne
    {
        return $this->hasOne(CameraExport::class);
    }

    public function callLetterExport(): HasOne
    {
        return $this->hasOne(CallLetterExport::class);
    }
}

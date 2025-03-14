<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CameraExport extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'start_datetime',
        'end_datetime',
        'success',
        'description',
        'sismo_register_id',
    ];

    public function cameras(): BelongsToMany
    {
        return $this->belongsToMany(Camera::class, 'camera_camera_exports');
    }

    public function sismoRegister(): BelongsTo
    {
        return $this->belongsTo(SismoRegister::class);
    }
}

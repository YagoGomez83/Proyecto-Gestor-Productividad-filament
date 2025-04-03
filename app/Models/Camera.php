<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Camera extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'identifier',
        'location_id',
        'city_id',
        'police_station_id',

    ];

    public function policeStation(): BelongsTo
    {
        return $this->belongsTo(PoliceStation::class, 'police_station_id');
    }


    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

 

    public function reports()
    {
        return $this->belongsToMany(Report::class, 'camera_report');
    }

    public function camerasExports(): BelongsToMany
    {
        return $this->belongsToMany(CameraExport::class, 'camera_camera_exports');
    }
    public function applicationForAdmissions(): BelongsToMany
    {
        return $this->belongsToMany(ApplicationForAdmission::class, 'application_for_admissions_cameras');
    }
    public function services():HasMany{
        return $this->hasMany(Service::class);
    }
}

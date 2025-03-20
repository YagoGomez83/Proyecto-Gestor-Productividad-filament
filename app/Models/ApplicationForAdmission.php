<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationForAdmission extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'user_id',
        'police_hierarchy',
        'cause_id',
        'police_station_id',
        'center_id',
        'observations',
    ];
    public function cause()
    {
        return $this->belongsTo(Cause::class);
    }
    public function policeStation()
    {
        return $this->belongsTo(PoliceStation::class);
    }
    public function center()
    {
        return $this->belongsTo(Center::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cameras(): BelongsToMany
    {
        return $this->belongsToMany(Camera::class, 'application_for_admissions_cameras');
    }
}

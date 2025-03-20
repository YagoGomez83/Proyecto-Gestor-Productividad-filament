<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'title',
        'description',
        'report_date',
        'report_time',
        'police_station_id',
        'location_id',
        'user_id',
        'cause_id'
    ];

    protected $casts = [
        'report_date' => 'date',
        'report_time' => 'datetime:H:i:s'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function policeStation(): BelongsTo
    {
        return $this->belongsTo(PoliceStation::class);
    }

    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class);
    }

    public function accuseds(): BelongsToMany
    {
        return $this->belongsToMany(Accused::class);
    }

    public function victims(): BelongsToMany
    {
        return $this->belongsToMany(Victim::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function cameras(): BelongsToMany
    {
        return $this->belongsToMany(Camera::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function specialReportRequest(): HasMany
    {
        return $this->hasMany(SpecialReportRequest::class);
    }
}

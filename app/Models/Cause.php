<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cause extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cause_name',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function sismoRegisters()
    {
        return $this->hasMany(SismoRegister::class);
    }
    public function aplicationForAdmissions(): HasMany
    {
        return $this->hasMany(ApplicationForAdmission::class);
    }
}

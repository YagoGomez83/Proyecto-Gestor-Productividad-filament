<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'group_id',
        'address',
        'phone_number',
        'city_id',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected $casts = [
    //     'role' => UserRole::class,  // Convierte automáticamente a enum
    // ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Métodos de verificación de rol
    // public function isOperator(): bool
    // {
    //     return $this->role === UserRole::OPERATOR;
    // }

    // public function isSupervisor(): bool
    // {
    //     return $this->role === UserRole::SUPERVISOR;
    // }

    // public function isCoordinator(): bool
    // {
    //     return $this->role === UserRole::COORDINATOR;
    // }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
    // Método para eliminar un usuario lógicamente

}

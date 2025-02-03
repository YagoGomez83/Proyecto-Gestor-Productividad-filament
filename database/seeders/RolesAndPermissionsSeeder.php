<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $coordinator = Role::firstOrCreate(['name' => 'coordinator']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
        $operator = Role::firstOrCreate(['name' => 'operator']);

        // Definir permisos
        $permissions = [
            'view cameras',
            'create cameras',
            'edit cameras',
            'delete cameras',
            'view locations',
            'create locations',
            'edit locations',
            'delete locations',
            'view services',
            'create services',
            'edit services',
            'delete services',
            'view cities',
            'create cities',
            'edit cities',
            'delete cities',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view groups',
            'create groups',
            'edit groups',
            'delete groups',
            'view police_movement_codes',
            'create police_movement_codes',
            'edit police_movement_codes',
            'delete police_movement_codes',
            'view police_stations',
            'create police_stations',
            'edit police_stations',
            'delete police_stations',
            'view regional_units',
            'create regional_units',
            'edit regional_units',
            'delete regional_units',
            'view sub_police_movement_codes',
            'create sub_police_movement_codes',
            'edit sub_police_movement_codes',
            'delete sub_police_movement_codes',
            'view work_sessions',
            'create work_sessions',
            'edit work_sessions',
            'delete work_sessions',


        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos a roles
        $coordinator->givePermissionTo($permissions);
        $supervisor->givePermissionTo(['view cameras', 'view locations', 'view services', 'create services', 'edit services', 'delete services', 'view cities', 'view users', 'view groups', 'view police_movement_codes', 'view police_stations', 'view regional_units', 'view sub_police_movement_codes', 'view work_sessions']);
        $operator->givePermissionTo(['view cameras', 'view services']);
    }
}

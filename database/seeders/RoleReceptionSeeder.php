<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleReceptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reception = Role::firstOrCreate(['name' => 'reception']);
        $permissions = [
            'view application_for_admissions',
            'create application_for_admissions',
            'edit application_for_admissions',
            'delete application_for_admissions',
            'view call_letter_exports',
            'create call_letter_exports',
            'edit call_letter_exports',
            'delete call_letter_exports',
            'view camera_exports',
            'create camera_exports',
            'edit camera_exports',
            'delete camera_exports',
            'view causes',
            'create causes',
            'edit causes',
            'delete causes',
            'view centers',
            'view cities',
            'view reports',
            'view solicitude_types',
            'create solicitude_types',
            'edit solicitude_types',
            'delete solicitude_types',
            'view sismo_registers',
            'create sismo_registers',
            'edit sismo_registers',
            'delete sismo_registers',
            'view special_report_requests',


        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $reception->givePermissionTo($permissions);
        //
    }
}

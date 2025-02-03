<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed de centros, unidades regionales, etc.
        DB::table('centers')->insert([
            'name' => 'CCCSL',
        ]);

        DB::table('regional_units')->insert([
            'name' => 'Unidad Regional 1',
            'center_id' => '1',
        ]);

        DB::table('cities')->insert([
            'name' => 'San Luis',
            'regional_unit_id' => '1',
        ]);

        DB::table('groups')->insert([
            'name' => 'Grupo 1',
            'center_id' => '1',
        ]);

        // Insertar el usuario admin
        DB::table('users')->insert([
            'name' => 'admin',
            'last_name' => 'test',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'phone_number' => '1234567890',
            'address' => '1234 Admin St',
            'city_id' => '1',
            'group_id' => '1',
        ]);

        // Insertar roles
        // Llamar al seeder de roles y permisos
        $this->call(RolesAndPermissionsSeeder::class);


        // Obtener el usuario admin recién creado
        $user = User::where('email', 'admin@admin.com')->first();

        // Asignar el rol de 'coordinator' al usuario admin
        $user->assignRole('coordinator');
    }
}

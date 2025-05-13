<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'Grupo A CCCSL',
            'center_id' => '1',
        ]);

        // Insertar el usuario admin
        $admin = User::create([
            'name' => 'admin',
            'last_name' => 'test',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'phone_number' => '1234567890',
            'address' => '1234 Admin St',
            'city_id' => '1',
            'group_id' => '1',
        ]);

        // Insertar usuario supervisor
        $supervisor = User::create([
            'name' => 'supervisor',
            'last_name' => 'test',
            'email' => 'supervisor@test.com',
            'password' => bcrypt('supervisor'),
            'phone_number' => '9876543210',
            'address' => '1234 Supervisor St',
            'city_id' => '1',
            'group_id' => '1',
        ]);

        // Insertar usuario operador
        $operator = User::create([
            'name' => 'operator',
            'last_name' => 'test',
            'email' => 'operator@test.com',
            'password' => bcrypt('operator'),
            'phone_number' => '5678901234',
            'address' => '1234 Operator St',
            'city_id' => '1',
            'group_id' => '1',
        ]);

        // Llamar al seeder de roles y permisos
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(RoleReceptionSeeder::class);

        // Asignar roles a los usuarios
        $admin->assignRole('coordinator');
        $supervisor->assignRole('supervisor');
        $operator->assignRole('operator');
    }
}

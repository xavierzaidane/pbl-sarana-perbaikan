<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Student', 'Lecturer', 'Staff', 'Technician', 'Infrastructure'];

        foreach ($roles as $role) {
            DB::table('users')->insert([
                'name' => $role . ' users',
                'username' => strtolower($role) . '_user',
                'password' => Hash::make('password'), // default password
                'email' => strtolower($role) . '@example.com',
                'role' => $role,
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

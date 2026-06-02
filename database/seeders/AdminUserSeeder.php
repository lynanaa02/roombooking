<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@unej.ac.id'],
            [
                'name' => 'Admin Universitas Jember',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'foto' => null
            ]
        );
    }
}

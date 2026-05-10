<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'Admin Sisa Guna',
            'email'             => 'admin@sisaguna.com',
            'password'          => Hash::make('admin123'),
            'role'              => 'admin',
            'kota'              => 'Bandung',
            'email_verified_at' => now(),
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Owner (Dibuat via Seeder/Admin, tidak melalui registrasi publik)
        User::create([
            'name' => 'Pemilik Kos',
            'email' => 'owner@kosmanage.com',
            'password' => Hash::make('Owner123!'),
            'role' => 'owner',
            'phone' => '081234567890',
            'status' => 'active',
        ]);

        // Akun Tenant Demo
        User::create([
            'name' => 'Penyewa Demo',
            'email' => 'tenant@kosmanage.com',
            'password' => Hash::make('Tenant123!'),
            'role' => 'tenant',
            'phone' => '089876543210',
            'status' => 'active',
        ]);
    }
}
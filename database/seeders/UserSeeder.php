<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Masukkan data user satu per satu dengan proteksi check email unik
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('password'),
                'role_id' => 1
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@test.com'],
            [
                'name' => 'Akun Staff',
                'password' => Hash::make('password'),
                'role_id' => 2
            ]
        );

        User::firstOrCreate(
            ['email' => 'spv@test.com'],
            [
                'name' => 'Akun SPV',
                'password' => Hash::make('password'),
                'role_id' => 3
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager@test.com'],
            [
                'name' => 'Akun Manager',
                'password' => Hash::make('password'),
                'role_id' => 4
            ]
        );

        User::firstOrCreate(
            ['email' => 'direktur@test.com'],
            [
                'name' => 'Akun Direktur',
                'password' => Hash::make('password'),
                'role_id' => 5
            ]
        );

        User::firstOrCreate(
            ['email' => 'finance@test.com'],
            [
                'name' => 'Akun Finance',
                'password' => Hash::make('password'),
                'role_id' => 6
            ]
        );

    }
}

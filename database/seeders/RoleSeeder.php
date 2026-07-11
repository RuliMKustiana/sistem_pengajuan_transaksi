<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'staff']);
        Role::firstOrCreate(['name' => 'spv']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'direktur']);
        Role::firstOrCreate(['name' => 'finance']);
        
    }
}
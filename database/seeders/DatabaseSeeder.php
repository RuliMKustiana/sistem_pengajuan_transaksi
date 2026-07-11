<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil RoleSeeder agar dieksekusi pertama kali
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        Category::firstOrCreate(['name' => 'PO Produk']);
        Category::firstOrCreate(['name' => 'Operasional']);
        Category::firstOrCreate(['name' => 'ATK']);
        Category::firstOrCreate(['name' => 'Lain-lain']);
        
    }

    
}

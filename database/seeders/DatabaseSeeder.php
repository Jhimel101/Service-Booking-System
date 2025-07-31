<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => true,
        ]);

        // Create regular user
        User::create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => false,
        ]);

        // Create services
        Service::create([
            'name' => 'Haircut',
            'description' => 'Professional haircut service',
            'price' => 25.00,
            'status' => true,
        ]);

        Service::create([
            'name' => 'Massage',
            'description' => 'Relaxing full body massage',
            'price' => 60.00,
            'status' => true,
        ]);

        Service::create([
            'name' => 'Manicure',
            'description' => 'Hand care and nail treatment',
            'price' => 35.00,
            'status' => true,
        ]);
    }
}

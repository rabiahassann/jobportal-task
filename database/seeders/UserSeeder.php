<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;  // Make sure to import the User model
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin', 
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'), 
            'role' => 'user', 
        ]);
    }
}

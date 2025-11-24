<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'firstname' => 'Admin',
            'lastname'  => 'User',
            'email'     => 'admin@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
        ]);

        // Staff User
        User::create([
            'firstname' => 'Staff',
            'lastname'  => 'Member',
            'email'     => 'staff@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'staff',
        ]);

        // Member User
        User::create([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'john@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'member',
        ]);
    }
}

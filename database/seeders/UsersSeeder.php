<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        User::create([
            'firstname' => 'Admin',
            'lastname'  => 'User',
            'email'     => 'admin@nmsc.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
        ]);

        // 2 Staff
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'firstname' => "Staff{$i}",
                'lastname'  => 'Member',
                'email'     => "staff{$i}@nmsc.com",
                'password'  => Hash::make('password'),
                'role'      => 'staff',
            ]);
        }

        // 2 Members
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'firstname' => "Member{$i}",
                'lastname'  => 'User',
                'email'     => "member{$i}@nmsc.com",
                'password'  => Hash::make('password'),
                'role'      => 'member',
            ]);
        }
    }
}

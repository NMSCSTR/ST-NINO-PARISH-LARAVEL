<?php
namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MembersSeeder extends Seeder
{
    public function run(): void
    {
        $memberUser = User::firstOrCreate(
            ['email' => 'john@enmsc.com'],
            [
                'firstname' => 'John',
                'lastname'  => 'Doe',
                'password'  => Hash::make('password'),
                'role'      => 'member',
            ]
        );

        Member::create([
            'user_id'        => $memberUser->id,
            'middle_name'    => 'Michael',
            'birth_date'     => '1995-05-20',
            'place_of_birth' => 'Manila',
            'address'        => '123 Main St',
            'contact_number' => '09123456789',
        ]);

        Member::create([
            'user_id'        => $memberUser->id,
            'middle_name'    => 'Michael',
            'birth_date'     => '1995-05-20',
            'place_of_birth' => 'Manila',
            'address'        => '123 Main St',
            'contact_number' => '09123456789',
        ]);

        if (! $memberUser) {
            throw new \Exception("User with email john@example.com not found.");
        }

    }
}

<?php
namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class MembersSeeder extends Seeder
{
    public function run(): void
    {
        $memberUser = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name'     => 'John Doe',
                'password' => bcrypt('password'),
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

    }
}

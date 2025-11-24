<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User;

class MembersSeeder extends Seeder
{
    public function run(): void
    {
        // Attach to the created member user
        $memberUser = User::where('email', 'john@example.com')->first();

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

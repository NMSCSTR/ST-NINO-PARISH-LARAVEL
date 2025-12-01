<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;

class MembersSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role', 'member')->get();

        foreach ($members as $memberUser) {
            Member::create([
                'user_id'        => $memberUser->id,
                'middle_name'    => 'Michael',
                'birth_date'     => '1995-05-20',
                'place_of_birth' => 'Manila',
                'address'        => '123 Main St',
                'contact_number' => '0912345678' . $memberUser->id,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Baptism;
use App\Models\Member;
use App\Models\User;

class BaptismsSeeder extends Seeder
{
    public function run(): void
    {
        $member = Member::first();
        $staff = User::where('role', 'staff')->first();

        Baptism::create([
            'member_id'      => $member->id,
            'user_id'        => $staff->id,
            'baptism_date'   => '2024-01-15',
            'name_of_father' => 'Carlos Doe',
            'name_of_mother' => 'Maria Doe',
            'baptized_by'    => 'Fr. Santos',
            'place'          => 'Local Church',
            'godfather'      => 'Jose Reyes',
            'godmother'      => 'Anna Cruz',
            'witnesses'      => json_encode(['Peter Cruz', 'Laura Santos']),
            'issued_by'      => $staff->id,
        ]);
    }
}

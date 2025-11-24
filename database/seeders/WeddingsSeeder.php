<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wedding;
use App\Models\User;
use App\Models\Member;

class WeddingsSeeder extends Seeder
{
    public function run(): void
    {
        $member = Member::first();
        $staff = User::where('role','staff')->first();

        Wedding::create([
            'husband_user_id'  => null,
            'wife_user_id'     => null,
            'husband_member_id'=> $member->id,
            'wife_member_id'   => $member->id,
            'wedding_date'     => '2024-03-10',
            'date_issued'      => '2024-03-11',
            'officiating_priest'=> 'Fr. Manuel',
            'licensed_no'      => 'LIC12345',
            'registration_no'  => 'REG67890',
            'witnesses'        => json_encode(['Mark Javier', 'Rina Santos']),
            'book_no'          => 1,
            'page'             => 5,
            'pageno'           => 9,
            'series_start'     => 2024,
            'series_end'       => 2024,
            'issued_by'        => $staff->id,
        ]);
    }
}

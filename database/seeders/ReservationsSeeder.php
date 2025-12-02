<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Member;
use App\Models\User;
use App\Models\Sacrament;

class ReservationsSeeder extends Seeder
{
    public function run(): void
    {
        $members    = Member::all();
        $sacraments = Sacrament::all();
        $staff      = User::where('role', 'staff')->first();

        if ($members->isEmpty() || $sacraments->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 5; $i++) {

            $sacrament = $sacraments->random();

            Reservation::create([
                'member_id'        => $members->random()->id,
                'sacrament_id'     => $sacrament->id, // NEW
                'type'             => $sacrament->sacrament_type,
                'fee'              => $sacrament->fee,
                'status'           => 'approved',
                'reservation_date' => now()->addDays($i),
                'remarks'          => "Reservation {$i} approved",
                'approved_by'      => $staff?->id,
            ]);
        }
    }
}

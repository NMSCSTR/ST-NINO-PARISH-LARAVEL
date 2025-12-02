<?php
namespace Database\Seeders;

use App\Models\Member;
use App\Models\Reservation;
use App\Models\Sacrament;
use App\Models\User;
use Illuminate\Database\Seeder;

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
                'sacrament_id'     => $sacrament->id,
                'fee'              => $sacrament->fee,
                'status'           => 'approved',
                'reservation_date' => now()->addDays($i),
                'remarks'          => "Reservation {$i} approved",
                'approved_by' => $staff?->id,
            ]);

        }
    }
}

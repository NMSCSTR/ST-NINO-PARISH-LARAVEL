<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Member;
use App\Models\Event;
use App\Models\User;

class ReservationsSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::all();
        $events  = Event::all();
        $staff   = User::where('role', 'staff')->first();

        for ($i = 1; $i <= 5; $i++) {
            Reservation::create([
                'member_id'        => $members->random()->id,
                'event_id'         => $events->random()->id,
                'type'             => 'general',
                'status'           => 'approved',
                'reservation_date' => now()->addDays($i),
                'remarks'          => "Reservation {$i} approved",
                'approved_by'      => $staff->id,
            ]);
        }
    }
}

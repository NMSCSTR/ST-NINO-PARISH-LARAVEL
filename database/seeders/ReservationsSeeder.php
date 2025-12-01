<?php
namespace Database\Seeders;

use App\Models\Member;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;

class ReservationsSeeder extends Seeder
{
    public function run(): void
    {
        $member = Member::first();
        $staff  = User::where('role', 'staff')->first();

        $event = Event::first();
        Reservation::create([
            'member_id'        => $member->id,
            'event_id'         => $event->id, 
            'type'             => 'wedding',
            'status'           => 'approved',
            'reservation_date' => '2024-07-10 14:00:00',
            'remarks'          => 'Approved by staff.',
            'approved_by'      => $staff->id,
        ]);

    }
}

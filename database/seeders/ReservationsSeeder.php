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
        $priest     = User::where('role', 'priest')->first();

        if ($members->isEmpty() || $sacraments->isEmpty() || !$staff || !$priest) {
            return;
        }

        for ($i = 1; $i <= 8; $i++) {
            $member    = $members->random();
            $sacrament = $sacraments->random();

            // Cycle through statuses for demo purposes
            if ($i % 4 === 1) {
                $status = 'pending';
                $approvedBy = null;
                $forwardedBy = null;
                $forwardedAt = null;
            } elseif ($i % 4 === 2) {
                $status = 'forwarded_to_priest';
                $approvedBy = null;
                $forwardedBy = $staff->id;
                $forwardedAt = now()->subDay();
            } elseif ($i % 4 === 3) {
                $status = 'approved';
                $approvedBy = $priest->id;
                $forwardedBy = $staff->id;
                $forwardedAt = now()->subDays(2);
            } else {
                $status = 'rejected';
                $approvedBy = $priest->id;
                $forwardedBy = $staff->id;
                $forwardedAt = now()->subDays(2);
            }

            Reservation::create([
                'member_id'        => $member->id,
                'sacrament_id'     => $sacrament->id,
                'fee'              => $sacrament->fee,
                'status'           => $status,
                'reservation_date' => now()->addDays($i),
                'remarks'          => "Reservation {$i} with status {$status}",
                'approved_by'      => $approvedBy,
                'forwarded_by'     => $forwardedBy,
                'forwarded_at'     => $forwardedAt,
            ]);
        }
    }
}

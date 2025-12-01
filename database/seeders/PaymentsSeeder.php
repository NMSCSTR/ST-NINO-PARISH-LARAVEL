<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Member;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = Reservation::all();

        foreach ($reservations as $reservation) {
            Payment::create([
                'reservation_id' => $reservation->id,
                'member_id'      => $reservation->member_id,
                'amount'         => rand(500, 5000),
                'method'         => 'GCash',
                'reference_no'   => 'REF' . rand(1000,9999),
                'status'         => 'paid',
                'receipt_path'   => 'receipts/sample.jpg',
            ]);
        }
    }
}


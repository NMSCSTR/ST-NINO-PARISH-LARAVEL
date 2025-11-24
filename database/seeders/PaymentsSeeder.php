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
        $reservation = Reservation::first();
        $member      = Member::first();

        Payment::create([
            'reservation_id' => $reservation->id,
            'member_id'      => $member->id,
            'amount'         => 1500.00,
            'method'         => 'GCash',
            'reference_no'   => 'GC123456789',
            'status'         => 'paid',
            'receipt_path'   => 'receipts/sample.jpg',
        ]);
    }
}

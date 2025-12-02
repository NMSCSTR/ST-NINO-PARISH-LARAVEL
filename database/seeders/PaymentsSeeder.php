<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Reservation;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = Reservation::all();

        foreach ($reservations as $reservation) {
            // randomly choose if payment was paid or pending
            $paymentStatus = rand(0, 1) ? 'paid' : 'pending';
            $paymentMethod = $paymentStatus === 'paid' ? 'GCash' : 'Pending';

            Payment::create([
                'reservation_id' => $reservation->id,
                'member_id'      => $reservation->member_id,
                'amount'         => $reservation->fee,
                'method'         => $paymentMethod,
                'reference_no'   => 'REF' . rand(1000, 9999),
                'status'         => $paymentStatus,
                'receipt_path'   => $paymentStatus === 'paid' ? 'receipts/sample.jpg' : null,
            ]);
        }
    }
}

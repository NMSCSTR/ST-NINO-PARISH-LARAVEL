<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            MembersSeeder::class,
            EventsSeeder::class,
            ReservationsSeeder::class,
            PaymentsSeeder::class,
            BaptismsSeeder::class,
            WeddingsSeeder::class,
        ]);
    }
}

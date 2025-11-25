<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::where('role', 'staff')->first();

        Event::create([
            'user_id'    => $staff->id,
            'title'      => 'Sunday Mass',
            'description'=> 'Regular Sunday mass.',
            'start_date' => '2026-06-02 08:00:00',
            'end_date'   => '2026-06-02 10:00:00',
            'type'       => 'mass',
        ]);
        Event::create([
            'user_id'    => $staff->id,
            'title'      => 'Monthly Mass & Wedding Orientations',
            'description'=> 'Monthly mass.',
            'start_date' => '2026-07-02 08:00:00',
            'end_date'   => '2026-08-02 10:00:00',
            'type'       => 'mass',
        ]);
    }
}

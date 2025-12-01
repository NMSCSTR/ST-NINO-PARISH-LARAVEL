<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $staffUsers = User::where('role', 'staff')->get();

        for ($i = 1; $i <= 5; $i++) {
            Event::create([
                'user_id'    => $staffUsers->random()->id,
                'title'      => "Event {$i}",
                'description'=> "Description for Event {$i}",
                'start_date' => now()->addDays($i),
                'end_date'   => now()->addDays($i)->addHours(2),
                'type'       => 'general',
            ]);
        }
    }
}

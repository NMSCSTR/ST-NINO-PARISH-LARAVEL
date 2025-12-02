<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sacrament;

class SacramentSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['sacrament_type' => 'wedding', 'fee' => 1000.00],
            ['sacrament_type' => 'baptism', 'fee' => 500.00],
            ['sacrament_type' => 'Burial Mass', 'fee' => 200.00],
        ];

        foreach ($data as $item) {
            Sacrament::create($item);
        }
    }
}

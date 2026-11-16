<?php

namespace Database\Seeders;

use App\Models\Studio;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        $studios = [
            [
                'name' => 'Studio A',
                'capacity' => '4-6 orang',
                'description' => 'AC, 2 mic, 3 speaker, 1 gitar listrik, 1 gitar bass, 1 keyboard, 1 drum',
                'price_per_hour' => 70000,
                'image' => 'images/studio-a.jpg',
                'status' => 'aktif',
            ],
            [
                'name' => 'Studio B',
                'capacity' => '8-10 orang',
                'description' => 'AC, 2 mic, 3 speaker, 1 gitar listrik, 1 gitar bass, 1 keyboard, 1 drum',
                'price_per_hour' => 70000,
                'image' => 'images/studio-b.jpg',
                'status' => 'aktif',
            ],
            [
                'name' => 'Studio C',
                'capacity' => '4-6 orang',
                'description' => 'AC, 2 mic, 3 speaker, 1 gitar listrik, 1 gitar bass, 1 keyboard, 1 drum',
                'price_per_hour' => 70000,
                'image' => 'images/studio-c.jpg',
                'status' => 'aktif',
            ],
        ];

        foreach ($studios as $studio) {
            Studio::updateOrCreate(['name' => $studio['name']], $studio);
        }
    }
}

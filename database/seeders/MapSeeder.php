<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Travels;
class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buina = Place::create([
            'name' => 'Buina Village',
            'lat' => 35.6895,
            'lng' => 139.6917,
            'description' => 'Rudeus was born here.'
        ]);

        $roa = Place::create([
            'name' => "Roa’s Mansion",
            'lat' => 34.6937,
            'lng' => 135.5023,
            'description' => 'Rudeus tutored Eris here.'
        ]);

        $millis = Place::create([
            'name' => 'Millis Continent',
            'lat' => 48.8566,
            'lng' => 2.3522,
            'description' => 'A later major adventure location.'
        ]);

        Travels::create([
            'from_place_id' => $buina->id,
            'to_place_id' => $roa->id,
            'type' => 'Carriage',
            'color' => 'red',
            'reason' => 'Traveled to tutor Eris'
        ]);

        Travels::create([
            'from_place_id' => $roa->id,
            'to_place_id' => $millis->id,
            'type' => 'Ship',
            'color' => 'blue',
            'reason' => 'Adventure journey to Millis Continent'
        ]);
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Travels;
use App\Models\PlaceVisit;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create a few places roughly across the image
        $places = [];
        $places['Buina'] = Place::create(['name' => 'Buina Village', 'description' => 'Birthplace', 'x' => 400, 'y' => 1600]);
        $places['Roa'] = Place::create(['name' => 'Roa City', 'description' => 'Tutored Eris', 'x' => 900, 'y' => 1500]);
        $places['Port'] = Place::create(['name' => 'West Port', 'description' => 'Set sail', 'x' => 1400, 'y' => 1300]);
        $places['Island'] = Place::create(['name' => 'Island Stop', 'description' => 'Midway stop', 'x' => 1900, 'y' => 1100]);
        $places['Millis'] = Place::create(['name' => 'Millis Capital', 'description' => 'Arrival', 'x' => 2400, 'y' => 900]);

        // Helper to make straight path between two places
        $line = function(Place $a, Place $b) {
            return [[ $a->y, $a->x ], [ $b->y, $b->x ]];
        };

        // Create travels (connections) and log occurrences as visits
        $seq = 1;

        $t1 = Travels::create([
            'name' => 'Connection between '.$places['Buina']->name.' and '.$places['Roa']->name,
            'type' => 'Carriage', 'color' => 'brown', 'reason' => 'Leaves home to tutor',
            'from_place_id' => $places['Buina']->id, 'to_place_id' => $places['Roa']->id,
            'path' => $line($places['Buina'], $places['Roa'])
        ]);
        PlaceVisit::create(['place_id' => $places['Roa']->id, 'travel_id' => $t1->id, 'travel_number' => $seq++, 'story_time' => 'Early journey', 'reason' => 'Tutoring job']);

        $t2 = Travels::create([
            'name' => 'Connection between '.$places['Roa']->name.' and '.$places['Port']->name,
            'type' => 'Carriage', 'color' => 'brown', 'reason' => 'To port',
            'from_place_id' => $places['Roa']->id, 'to_place_id' => $places['Port']->id,
            'path' => $line($places['Roa'], $places['Port'])
        ]);
        PlaceVisit::create(['place_id' => $places['Port']->id, 'travel_id' => $t2->id, 'travel_number' => $seq++, 'story_time' => 'Before ship', 'reason' => 'Boarding ship']);

        $t3 = Travels::create([
            'name' => 'Connection between '.$places['Port']->name.' and '.$places['Island']->name,
            'type' => 'Ship', 'color' => 'blue', 'reason' => 'Sea route',
            'from_place_id' => $places['Port']->id, 'to_place_id' => $places['Island']->id,
            'path' => $line($places['Port'], $places['Island'])
        ]);
        PlaceVisit::create(['place_id' => $places['Island']->id, 'travel_id' => $t3->id, 'travel_number' => $seq++, 'story_time' => 'Mid-voyage', 'reason' => 'Resupply']);

        $t4 = Travels::create([
            'name' => 'Connection between '.$places['Island']->name.' and '.$places['Millis']->name,
            'type' => 'Ship', 'color' => 'blue', 'reason' => 'Final leg',
            'from_place_id' => $places['Island']->id, 'to_place_id' => $places['Millis']->id,
            'path' => $line($places['Island'], $places['Millis'])
        ]);
        PlaceVisit::create(['place_id' => $places['Millis']->id, 'travel_id' => $t4->id, 'travel_number' => $seq++, 'story_time' => 'Arrival', 'reason' => 'Reached capital']);

        // Demonstrate reusing a travel (go back to Port)
        PlaceVisit::create(['place_id' => $places['Port']->id, 'travel_id' => $t3->id, 'travel_number' => $seq++, 'story_time' => 'Return trip', 'reason' => 'Back to port']);
    }
}

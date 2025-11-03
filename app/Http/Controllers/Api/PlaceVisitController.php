<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlaceVisit;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceVisitController extends Controller
{
    public function index() {
        return PlaceVisit::with(['place','travel'])->orderBy('travel_number')->get();
    }

    public function indexByPlace(Place $place) {
        return $place->visits()->orderBy('travel_number')->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'place_id' => 'required|exists:places,id',
            'travel_id' => 'nullable|exists:travels,id',
            'travel_number' => 'nullable|integer',
            'story_time' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);
        return PlaceVisit::create($data);
    }

    public function destroy(PlaceVisit $placeVisit) {
        $placeVisit->delete();
        return response()->noContent();
    }
}

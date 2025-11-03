<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index() {
        return Place::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);
        return Place::create($data);
    }

    public function show(Place $place) {
        return $place->load('visits');
    }

    public function update(Request $request, Place $place) {
        $place->update($request->only('name', 'description', 'x', 'y'));
        return $place;
    }

    public function destroy(Place $place) {
        $place->delete();
        return response()->noContent();
    }
}

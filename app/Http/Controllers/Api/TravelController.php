<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Travels;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {
        return Travels::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'type' => 'nullable|string',
            'color' => 'nullable|string',
            'reason' => 'nullable|string',
            'path' => 'required|array',
            'from_place_id' => 'nullable|exists:places,id',
            'to_place_id' => 'nullable|exists:places,id',
        ]);
        return Travels::create($data);
    }

    public function update(Request $request, Travels $travel)
    {
        $travel->update($request->all());
        return $travel;
    }

    public function destroy(Travels $travel)
    {
        $travel->delete();
        return response()->noContent();
    }
}

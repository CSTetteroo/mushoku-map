<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceVisit extends Model
{
    use HasFactory;

    protected $fillable = ['place_id', 'travel_id', 'travel_number', 'story_time', 'reason'];

    public function place() {
        return $this->belongsTo(Place::class);
    }

    public function travel() {
        return $this->belongsTo(Travels::class, 'travel_id');
    }
}


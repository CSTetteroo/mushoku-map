<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'x', 'y'];

    public function visits() {
        return $this->hasMany(PlaceVisit::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travels extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'color', 'reason', 'path', 'from_place_id', 'to_place_id'];

    protected $casts = [
        'path' => 'array',
    ];
}


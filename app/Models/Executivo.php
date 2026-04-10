<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cargo',
        'nome',
        'foto',
    ];
}
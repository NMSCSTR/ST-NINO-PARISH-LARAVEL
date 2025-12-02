<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sacrament extends Model
{
    use HasFactory;

    protected $fillable = [
        'sacrament_type',
        'fee',
    ];
}


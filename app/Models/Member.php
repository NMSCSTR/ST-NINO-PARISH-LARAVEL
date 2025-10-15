<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'address',
        'place_of_birth',
        'contact_number',
        'email',
    ];

    public function Baptism() {
        return $this->hasMany(Baptism::class);
    }

    public function weddings() {
        return $this->hasMany(Wedding::class);
    }

}

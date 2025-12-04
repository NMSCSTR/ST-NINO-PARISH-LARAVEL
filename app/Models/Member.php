<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'middle_name',
        'birth_date',
        'address',
        'place_of_birth',
        'contact_number',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Baptism()
    {
        return $this->hasMany(Baptism::class);
    }

    public function weddings()
    {
        return $this->hasMany(Wedding::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sacrament extends Model
{
    use HasFactory;

    protected $fillable = [
        'sacrament_type',
        'fee',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

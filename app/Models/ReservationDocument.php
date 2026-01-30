<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationDocument extends Model
{
    protected $fillable = [
        'reservation_id',
        'file_path',
        'file_type',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

}

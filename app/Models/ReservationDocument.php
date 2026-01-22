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
        // Make sure this matches the foreign key in your migration
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

}

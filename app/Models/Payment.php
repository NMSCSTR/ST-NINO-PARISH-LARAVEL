<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $fillable = [
        'reservation_id',
        'member_id',
        'amount',
        'method',
        'reference_no',
        'status',
        'receipt_path',
    ];

    public function reservations() {
        return $this->belongsTo(Reservation::class);
    }
    public function member() {
        return $this->belongsTo(member::class);
    }

}

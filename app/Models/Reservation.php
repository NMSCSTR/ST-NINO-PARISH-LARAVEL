<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $fillable = [
        'member_id',
        'event_id',
        'status',
        'reservation_date',
        'remarks',
        'approved_by',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function approvedBy() {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'sacrament_id',
        'fee',
        'reservation_date',
        'remarks',
        'status',
        'approved_by',
        'forwarded_by',
        'forwarded_at',
    ];

    protected $dates = [
        'reservation_date',
        'forwarded_at',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function sacrament()
    {
        return $this->belongsTo(Sacrament::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function documents()
    {
        return $this->hasMany(ReservationDocument::class);
    }

    // Staff forwarding relation
    public function forwardedByUser()
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }

    // Priest approval relation
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

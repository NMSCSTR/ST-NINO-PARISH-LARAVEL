<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baptism extends Model
{
    protected $fillable = [
        'member_id',
        'user_id',
        'baptism_date',
        'name_of_father',
        'name_of_mother',
        'baptized_by',
        'place',
        'godfather',
        'godmother',
        'witnesses',
    ];

    protected $casts = [
        'witnesses' => 'array',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

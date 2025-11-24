<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    protected $fillable = [
        'husband_user_id',
        'wife_user_id',
        'husband_member_id',
        'wife_member_id',
        'wedding_date',
        'date_issued',
        'officiating_priest',
        'licensed_no',
        'registration_no',
        'witnesses',
        'book_no',
        'page',
        'pageno',
        'series_start',
        'series_end',
        'issued_by',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'date_issued' => 'date',
        'book_no' => 'integer',
        'page' => 'integer',
        'pageno' => 'integer',
        'series_start' => 'integer',
        'series_end' => 'integer',
        'witnesses' => 'array',
    ];


    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}

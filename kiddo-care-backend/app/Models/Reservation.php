<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'start_time',
        'duration_minutes',
        'status',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
    ];

    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_reservation');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected $appends = ['end_time'];

    public function getEndTimeAttribute()
    {
        return $this->start_time ? Carbon::parse($this->start_time)->addMinute($this->duration_minutes)->toDateTimeString() : null;
    }
}

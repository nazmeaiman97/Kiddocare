<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'birthdate',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'child_reservation');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address'
    ];

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

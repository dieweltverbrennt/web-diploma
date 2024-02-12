<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = ['hall_number', 'seat_count', 'rows_count', 'seats_in_row_count', 'is_active'];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}

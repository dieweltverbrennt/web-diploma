<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'seat_id', 'booking_code'];

    public function session() {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function seat() {
        return $this->belongsTo(Seat::class, 'seat_id');
    }
}

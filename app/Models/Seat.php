<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['row_number', 'seat_number', 'hall_id', 'type', 'is_free', 'price'];
    public $timestamps = false;

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}

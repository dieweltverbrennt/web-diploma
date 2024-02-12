<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['start_time', 'end_time', 'film_id', 'hall_id'];

    public function film() {
        return $this->belongsTo(Film::class, 'film_id');
    }

    public function hall() {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}

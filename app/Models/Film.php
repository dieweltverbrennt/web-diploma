<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'production_country', 'duration', 'path_to_image'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}

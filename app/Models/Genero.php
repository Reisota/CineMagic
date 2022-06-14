<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;
    

    public function filme()
    {
        return $this->belongsTo(Filme::class,'genero_code','code');
    }
}

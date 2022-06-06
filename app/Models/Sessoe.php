<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessoe extends Model
{
    use HasFactory;

    public function filmes()
    {
        return $this->belongsTo(Filme::class,'filme_id','id');
    }
}

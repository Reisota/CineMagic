<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'genero_code','ano','cartaz_url','sumario','trailer_url'];
    public function sessoesDisponiveis()
    {
        return $this->hasMany(Sessoe::class,'filme_id','id');
    }
}

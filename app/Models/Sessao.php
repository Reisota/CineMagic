<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    use HasFactory;
    protected $table = 'sessoes';
    protected $fillable = ['data', 'horario_inicio','sala_id'];
    public function filmes()
    {
        return $this->belongsTo(Filme::class,'filme_id','id');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}

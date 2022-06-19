<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sala extends Model
{
    use HasFactory,SoftDeletes;

    public function Sessoes()
    {
        return $this->hasMany(Sessoes::class);
    }
    
    protected $fillable = ['nome'];

    public $timestamps = false;

    public function Lugar()
    {
            return $this->hasMany(Lugar::class,'id','sala_id');
    }
}

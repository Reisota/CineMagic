<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;
    protected $table = 'configuracao';

    protected $fillable = [
        'preco_bilhete_sem_iva',
        'percentagem_iva',
    ];

    public $timestamps = false;
}

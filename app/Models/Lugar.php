<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;
    protected $table = 'lugares';

    protected $fillable = [
        'fila',
        'posicao',
    ];

    protected $hidden = [
        'custom',
        'deleted_at',
    ];

    public function Sala()
    {
        return $this->belongsTo(Sala::class);
    }
    public $timestamps = false;
}

<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;

class EstatisticasController extends Controller
{
    public function admin_index()
    {
        $totalFilmes2022 = Filme::whereYear('updated_at' , 2022)->count();
        $totalFilmes1 = Filme::whereMonth('updated_at' , '01')->whereYear('updated_at' , 2022)->count();
        $totalFilmes2 = Filme::whereMonth('updated_at' , '02')->whereYear('updated_at' , 2022)->count();
        $totalFilmes3 = Filme::whereMonth('updated_at' , '03')->whereYear('updated_at' , 2022)->count();
        $totalFilmes4 = Filme::whereMonth('updated_at' , '04')->whereYear('updated_at' , 2022)->count();
        $totalFilmes5 = Filme::whereMonth('updated_at' , '05')->whereYear('updated_at' , 2022)->count();
        $totalFilmes6 = Filme::whereMonth('updated_at' , '06')->whereYear('updated_at' , 2022)->count();
        $totalFilmes7 = Filme::whereMonth('updated_at' , '07')->whereYear('updated_at' , 2022)->count();
        $totalFilmes8 = Filme::whereMonth('updated_at' , '08')->whereYear('updated_at' , 2022)->count();
        $totalFilmes9 = Filme::whereMonth('updated_at' , '09')->whereYear('updated_at' , 2022)->count();
        $totalFilmes10 = Filme::whereMonth('updated_at' , '10')->whereYear('updated_at' , 2022)->count();
        $totalFilmes11 = Filme::whereMonth('updated_at' , '11')->whereYear('updated_at' , 2022)->count();
        $totalFilmes12 = Filme::whereMonth('updated_at' , '12')->whereYear('updated_at' , 2022)->count();
        return view('estatisticas.admin')
            ->with('totalFilmes2022', $totalFilmes2022)
            ->with('totalFilmes1', $totalFilmes1)
            ->with('totalFilmes2', $totalFilmes2)
            ->with('totalFilmes3', $totalFilmes3)
            ->with('totalFilmes4', $totalFilmes4)
            ->with('totalFilmes5', $totalFilmes5)
            ->with('totalFilmes6', $totalFilmes6)
            ->with('totalFilmes7', $totalFilmes7)
            ->with('totalFilmes8', $totalFilmes8)
            ->with('totalFilmes9', $totalFilmes9)
            ->with('totalFilmes10', $totalFilmes10)
            ->with('totalFilmes11', $totalFilmes11)
            ->with('totalFilmes12', $totalFilmes12);
    }
}

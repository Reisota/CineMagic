<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use App\Models\Genero;
use App\Models\Sessoe;
use Faker\Core\File;
use Illuminate\Http\Request;

class FilmeController extends Controller
{
    public function index(Request $request)
    {
        $generos = Genero::pluck('nome', 'code');

        $pesquisa = $request->query('pesquisa', '');
        $genero = $request->genero;



        if ($genero != null) {
            $filmes = Filme::with('sessoesDisponiveis')
                ->where(function ($query) use ($pesquisa) {
                    $query->where('sumario', 'like', '%' . $pesquisa . '%')
                        ->orWhere('titulo', 'like', '%' . $pesquisa . '%');
                })
                ->where('genero_code', $genero)
                ->whereHas('sessoesDisponiveis', function ($query) {
                    $query->where('data', '>=', date("Y-m-d"));
                })
                ->get();
        } else {
            $filmes = Filme::with(['sessoesDisponiveis'])
                ->where(function ($query) use ($pesquisa) {
                    $query->where('sumario', 'like', '%' . $pesquisa . '%')
                        ->orWhere('titulo', 'like', '%' . $pesquisa . '%');
                })
                ->whereHas('sessoesDisponiveis', function ($query) {
                    $query->where('data', '>=', date("Y-m-d"));
                })
                ->get();
        }


        return view('filmes.index')
            ->with('filmes', $filmes)
            ->with('generos', $generos)
            ->with('genero', $genero)
            ->with('pesquisa', $pesquisa);
    }


    public function info($filme_id)
    {

        $filme = Filme::findOrFail($filme_id);
        $genero = Genero::where("code", $filme->genero_code)->get();
        $sessoes = Sessoe::where("filme_id", $filme_id)
            ->where('data', '>=', date("Y-m-d"))
            ->get();

        return view('filmes.detalhes')
            ->with('filme', $filme)
            ->with('genero', $genero)
            ->with('sessoes', $sessoes);
    }

    public function sessao($sessao_id)
    {

        $sessao_escolhida = Sessoe::findOrFail($sessao_id); //info da sessão escolhida
        $filme = Filme::findOrFail($sessao_escolhida->filme_id); //filme da sessão escolhida
        $genero = Genero::where("code", $filme->genero_code)->get(); //genero do filme
        $sessoes = Sessoe::where("filme_id",$sessao_escolhida->filme_id) //sessoes disponiveis do filme
        ->where('data', '>=', date("Y-m-d"))
        ->get();
  
        return view('filmes.sessao')
            ->with('sessao_escolhida', $sessao_escolhida)
            ->with('sessoes', $sessoes)
            ->with('genero', $genero)
            ->with('filme', $filme);
    }
}

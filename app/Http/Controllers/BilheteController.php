<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Cliente;
use App\Models\Lugar;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Http\Request;

class BilheteController extends Controller
{
    public function verificacao_index(Request $request)
    {
        $filmes = Filme::pluck('titulo', 'id');
        $filme =  $request->query('filme', new Filme());

        if ($request->filme != '' && $request->sala != '') {
            $sessao=new Sessao();
            if($request->sessao != ''){
                $sessao = Sessao::findOrFail($request->sessao);
            }
            $filme = Filme::findOrFail($request->filme);

            $sala = Sala::findOrFail($request->sala);
            $salas = Sala::pluck('nome', 'id');
            $sessoes = Sessao::where('filme_id', $request->filme)
                ->where('data', '>=', date("Y-m-d"))
                ->where('sala_id', $request->sala)
                ->get();
            $bilhete = new Bilhete();
            return view('funcionarios.controloAcesso')
                ->with('sala', $sala)
                ->with('salas', $salas)
                ->with('filmes', $filmes)
                ->with('sessoes',$sessoes)
                ->with('bilhete', $bilhete)
                ->with('filme', $filme);
        }

        if ($request->filme != '') {

            $filme = Filme::findOrFail($request->filme);
            $salas = Sala::pluck('nome', 'id');



            return view('funcionarios.controloAcesso')
                ->with('sessao_escolhida', '')
                ->with('sala', new Sala())
                ->with('salas', $salas)
                ->with('filmes', $filmes)
                ->with('filme', $filme);
        }

        return view('funcionarios.controloAcesso')
            ->with('filmes', $filmes)
            ->with('filme', $filme);
    }


    public function verificacao(Request $request, Sessao $sessao)
    {
        $validated_data = $request->validate([
            'bilhete_id' => 'required|integer',
        ]);
        $filmes = Filme::pluck('titulo', 'id');
        $filme = Filme::findOrFail($sessao->filme_id);
        $sessoes = Sessao::where('filme_id', $filme->id)
            ->where('data', '>=', date("Y-m-d"))
            ->get();
        $salas = Sala::pluck('nome', 'id');

        $verificarBihete = Bilhete::find($validated_data['bilhete_id']);

        $cliente = User::Find($verificarBihete->cliente_id);

        $lugar = Lugar::Find($verificarBihete->lugar_id);

        $sala = Sala::Find($lugar->sala_id);

        if ($verificarBihete->sessao_id == $sessao->id) {
            return view('funcionarios.controloAcesso')
                ->with('bilhete', $verificarBihete)
                ->with('sessao_escolhida', $sessao)
                ->with('sessoes', $sessoes)
                ->with('filmes', $filmes)
                ->with('filme', $filme)
                ->with('cliente', $cliente)
                ->with('lugar', $lugar)
                ->with('sala', $sala)
                ->with('salas', $salas)
                ->with('valido', true);
        }
        return view('funcionarios.controloAcesso')
            ->with('bilhete', $verificarBihete)
            ->with('sessao_escolhida', $sessao)
            ->with('sessoes', $sessoes)
            ->with('filmes', $filmes)
            ->with('filme', $filme)
            ->with('sala', $sala)
            ->with('salas', $salas)
            ->with('valido', false);
    }



    public function update(Request $request, Bilhete $bilhete)
    {
        $bilhete->estado = 'usado';
        $bilhete->save();

        return redirect()->route('verificacao')
            ->with('alert-msg', 'Bilhete foi usado com sucesso!')
            ->with('alert-type', 'success');
    }
}

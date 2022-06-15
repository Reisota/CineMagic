<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessao;
use App\Models\Filme;
use App\Models\Sala;

class SessaoController extends Controller
{

    public function admin_index(Filme $filme, Request $request)
    {
        $data = $request->data;
    
        if ($data != null) {
            $sessoes = Sessao::with('sala')
                ->where('filme_id', $filme->id)
                ->where('data',$data)
                ->orderBy('data', 'desc')
                ->get();
        }else{
            $sessoes = Sessao::with('sala')
            ->where('filme_id', $filme->id)
            ->orderBy('data', 'desc')
            ->get();

        }

        return view('sessoes.admin')
            ->with('filme', $filme)
            ->with('sessoes', $sessoes)
            ->with('data',$data);
    }


    public function edit(Sessao $sessao)
    {

        $sala = Sala::find($sessao->sala_id);
        $salas = Sala::pluck('nome', 'id');
        $filme = Filme::find($sessao->filme_id);
        return view('sessoes.edit')
            ->with('sessao', $sessao)
            ->with('filme', $filme)
            ->with('sala', $sala)
            ->with('salas', $salas);
    }

    public function create(Filme $filme)
    {
        $sessao = new Sessao();
        $sala = new Sala();
        $salas = Sala::pluck('nome', 'id');
        return view('sessoes.create')
            ->with('filme', $filme)
            ->with('sala', $sala)
            ->with('sessao', $sessao)
            ->with('salas', $salas);
    }

    public function store(Request $request)
    {
        $filme = Filme::find($request->filme_id);
        $validated_data = $request->validate([
            'data' => 'required|date_format:Y-m-d',
            'horario_inicio' => 'required|date_format:H:i',
            'sala_id' => 'required',
        ]);
        $newSessao = new Sessao();
        $newSessao->fill($validated_data);
        $newSessao->filme_id = $request->filme_id;
        $newSessao->save();

        return redirect()->route('admin.sessoes', ['filme' => $filme])
            ->with('alert-msg', 'Sessão criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(Request $request, Sessao $sessao)
    {

        $filme = Filme::find($sessao->filme_id);
        $validated_data = $request->validate([
            'data' => 'required|date_format:Y-m-d',
            'horario_inicio' => 'required|date_format:H:i',
            'sala_id' => 'required',
        ]);
        $sessao->fill($validated_data);

        $sessao->save();

        return redirect()->route('admin.sessoes', ['filme' => $filme])
            ->with('alert-msg', 'Sessão alterada com sucesso!')
            ->with('alert-type', 'success');
    }



    public function destroy(Sessao $sessao)
    {
        $filme = Filme::find($sessao->filme_id);
        try {
            $sessao->delete();
            return redirect()->route('admin.sessoes', ['filme' => $filme])
                ->with('alert-msg', 'Sessão foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.sessoes', ['filme' => $filme])
                    ->with('alert-msg', 'Não foi possível apagar a sessão, porque esta está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.sessoes', ['filme' => $filme])
                    ->with('alert-msg', 'Não foi possível apagar o sessão Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Lugar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

class SalaController extends Controller
{
    public function admin_index(Request $request)
    {

        $pesquisa = $request->query('pesquisa', '');
        $salas = Sala::where(function ($query) use ($pesquisa) {
            $query->where('nome', 'like', '%' . $pesquisa . '%');

        })
            ->get();

        return view('salas.admin')
            ->with('salas', $salas)
            ->with('pesquisa', $pesquisa);
    }


    public function edit(Sala $sala)
    {
        
        $user = Sala::findOrFail($sala->id);

        $count = Lugar::where('sala_id','=',$user->id) 
                ->where('fila','=','A')->count();
        $count1 = Lugar::where('sala_id','=',$user->id)->count();
        $count2 = ($count1 / $count);

        //$lugares = Lugar::where('sala_id',$user->id)->get();

        return view('salas.edit')
            ->with('sala', $user)
           //->with('lugares', $lugares);
            ->with('lugares', $count)
            ->with('lugares2', $count2);
            
    }
    

    public function create()
    {
        $lugares = Lugar::pluck('fila', 'posicao');
        $sala = new Sala();
        return view('salas.create')
            ->with('sala', $sala)
            ->with('lugares', $lugares);
    }

    public function store(Request $request)
    {

        $validated_data = $request->validate([
            'nome' => 'required|max:255',
            'fila' => 'required|integer|min:0|max:50',
            'posicao' => 'required|integer|min:0|max:50'
        ]);
        $newSala = new Sala;
        $newSala->fill($validated_data);
        $newSala->save();

        return redirect()->route('admin.salas')
            ->with('alert-msg', 'Sala "' . $validated_data['nome'] . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(Request $request, Sala $sala)
    {
        $validated_data = $request->validate([
            'nome' => 'required|max:255',
            'fila' => 'required|integer|min:0|max:50',
            'posicao' => 'required|integer|min:0|max:50'
        ]);
        $sala->fill($validated_data);

        $sala->save();

        return redirect()->route('admin.salas')
            ->with('alert-msg', 'Sala "' . $sala->nome . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }


    public function destroy(Sala $sala)
    {
        $oldName = $sala->nome;
        try {
            $sala->delete();
            return redirect()->route('admin.salas')
                ->with('alert-msg', 'sala "' . $sala->nome . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.salas')
                    ->with('alert-msg', 'Não foi possível apagar a Sala "' . $oldName . '", porque esta sala está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.salas')
                    ->with('alert-msg', 'Não foi possível apagar a Sala "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }
}










   
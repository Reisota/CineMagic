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

        $sala = Sala::findOrFail($sala->id);

        $fila = Lugar::where('sala_id', $sala->id)
            ->where('posicao', 1)->count();
        $posicao = Lugar::where('sala_id', $sala->id)
        ->where('fila', 'A')->count();
        //$lugares = Lugar::where('sala_id',$user->id)->get();

        return view('salas.edit')
            ->with('sala', $sala)
            //->with('lugares', $lugares);
            ->with('lugares', $fila)
            ->with('lugares2', $posicao);
    }


    public function create()
    {
        $lugares = '';
        $sala = new Sala;
        $nome = '';


        return view('salas.create')
            ->with('sala', $sala)
            ->with('lugares', $lugares)
            ->with('nome', $nome);
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'nome' => 'required|max:255',
            'fila' => 'required|integer|min:0|max:50',
            'posicao' => 'required|integer|min:0|max:50'
        ]);
        $data = array(
            "1" => "A",
            "2" => "B",
            "3" => "C",
            "4" => "D",
            "5" => "E",
            "6" => "F",
            "7" => "G",
            "8" => "H",
            "9" => "I",
            "10" => "J",
            "11" => "K",
            "12" => "L",
            "13" => "M",
            "14" => "N",
            "15" => "O",
            "16" => "P",
            "17" => "Q",
            "18" => "R",
            "19" => "S",
            "20" => "T",
            "21" => "U",
            "22" => "V",
            "23" => "W",
            "24" => "X",
            "25" => "Y",
            "26" => "Z",
        );
        $newSala = new Sala;
        $newSala->fill($validated_data);
        $newSala->save();
        $contador = 0;
        foreach ($data as $teste) {
            $contador++;
            if ($contador <= $request->fila) {

                $exp = 1;
                while ($exp <= $request->posicao) {
                    $lugar = new Lugar;
                    $lugar->fila = $teste;
                    $lugar->sala_id = $newSala->id;
                    $lugar->posicao = $exp;
                    $lugar->save();
                    $exp++;
                }
            }
        }
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
        $data = array(
            "1" => "A",
            "2" => "B",
            "3" => "C",
            "4" => "D",
            "5" => "E",
            "6" => "F",
            "7" => "G",
            "8" => "H",
            "9" => "I",
            "10" => "J",
            "11" => "K",
            "12" => "L",
            "13" => "M",
            "14" => "N",
            "15" => "O",
            "16" => "P",
            "17" => "Q",
            "18" => "R",
            "19" => "S",
            "20" => "T",
            "21" => "U",
            "22" => "V",
            "23" => "W",
            "24" => "X",
            "25" => "Y",
            "26" => "Z",
        );
        /*
        $sala->fill($validated_data);
        $sala->save();
        $lugar = Lugar::where('sala_id',$sala->id);
        
        foreach ($data as $teste){
            $lugar->fila = $teste;
            for ($i=0;$i>$request->posicao;$i++){
                $lugar->posicao = $i;
                $lugar->save();
            }
        }

        /*
        foreach ($lugar as $lugares){
            $lugares->posicao = $validated_data['posicao'];
        }
        */


        //$lugar->save(); 
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

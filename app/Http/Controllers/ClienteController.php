<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cliente = Cliente::find($user->id);
        if ($cliente == null) {
            $cliente = new Cliente();
        }
        return view('clientes.index')
            ->with('user', $user)
            ->with('cliente', $cliente);
    }

    public function admin_index(Request $request)
    {
        $pesquisa = $request->query('pesquisa', '');
        $users = User::where("tipo", 'C')
            ->where(function ($query) use ($pesquisa) {
                $query->where('name', 'like', '%' . $pesquisa . '%')
                    ->orWhere('email', 'like', '%' . $pesquisa . '%');
            })
            ->get();

        return view('clientes.admin')
            ->with('users', $users)
            ->with('pesquisa', $pesquisa);
    }


    public function edit(User $user)
    {
        return view('clientes.edit')
            ->with($user);
    }



    public function update(Request $request, User $user)
    {
        $validated_data = $request->validate([

            'name' => 'required|max:255',
            'nif' => 'digits:9|nullable',
            'tipo_pagamento' => 'max:25|nullable',
            'ref_pagamento' => 'digits:9|nullable',

        ]);
        $user->fill($validated_data);
        $cliente = Cliente::find($user->id);
        $user->name = $validated_data['name'];


        if ($request->hasFile('foto')) {
            Storage::delete('public/fotos/' . $user->foto_url);
            $path = $request->foto->store('public/fotos');
            $user->foto_url = basename($path);
        }

        $user->save();

        //$cliente->nif =  $request->nif;
        //$cliente->nif = $validated_data['nif'];
        //dd($cliente->nif);
        $cliente->nif = $validated_data['nif'];
        $cliente->tipo_pagamento = $validated_data['tipo_pagamento'];
        $cliente->ref_pagamento = $validated_data['ref_pagamento'];
        
        $cliente->save();

        return redirect()->route('clientes')
            ->with('alert-msg', 'cliente "' . $user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }



    public function destroy(User $user)
    {
        $oldName = $user->name;
        $oldUrlFoto = $user->foto_url;

        $cliente = Cliente::find($user->id);

        try {
            $cliente->delete();
            $user->delete();
            Storage::delete('public/fotos/' . $oldUrlFoto);
            return redirect()->route('admin.clientes')
                ->with('alert-msg', 'Utilizador "' . $user->name . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.clientes')
                    ->with('alert-msg', 'Não foi possível apagar o Utilizador "' . $oldName . '", porque este utilizador está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.clientes')
                    ->with('alert-msg', 'Não foi possível apagar o Utilizador "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }


    public function bloquiar_desbloquiar(Request $request, User $user)
    {
        $validated_data = $request->validate([
            'bloqueado' => 'required|in:0,1',
        ]);

        $user->fill($validated_data);

        $user->save();
        if ($request->bloqueado == '1') {
            return redirect()->route('admin.clientes')
                ->with('alert-msg', 'Utilizador "' . $user->name . '" foi bloquiado com sucesso!')
                ->with('alert-type', 'success');
        } else {
            return redirect()->route('admin.clientes')
                ->with('alert-msg', 'Utilizador "' . $user->name . '" foi desbloquiado com sucesso!')
                ->with('alert-type', 'success');
        }
    }
}

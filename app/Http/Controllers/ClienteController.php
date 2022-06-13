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
        $user= Auth::user();
        $cliente = Cliente::find($user->id);
        if ($cliente == null) {
            $cliente = new Cliente();
        }
        $cliente->nif=0;
        return view('clientes.index')
            ->with('user', $user)
            ->with('cliente', $cliente);

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

        ]);
        $user->fill($validated_data);

        if ($request->hasFile('foto')) {

            Storage::delete('public/fotos/' . $user->url_foto);
            dd($request->foto->store('public/fotos'));
            $path = $request->foto->store('public/fotos');

            $user->url_foto = basename($path);
        }

        $user->save();

        return redirect()->route('clientes')
            ->with('alert-msg', 'clientes "' . $user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(User $disciplina)
    {
    }
}

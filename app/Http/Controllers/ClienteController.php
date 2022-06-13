<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where("tipo", 'A')
            ->orWhere("tipo", 'F')
            ->get();

        return view('clientes.index')
            ->with('clientes', $users);
    }


    public function edit(User $user)
    {

        $user = User::findOrFail($user->id);

        return view('clientes.edit')
            ->with('clientes', $user);
    }


    public function update(Request $request, User $user)
    {
        $validated_data = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'tipo' => 'required|in:A,F',
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
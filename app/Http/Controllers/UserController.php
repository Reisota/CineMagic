<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function admin_index(Request $request)
    {
        $users = User::where("tipo", 'A')
            ->orWhere("tipo", 'F')
            ->get();

        return view('funcionarios.admin')
            ->with('users', $users);
    }


    public function edit(User $user)
    {

        $user = User::findOrFail($user->id);

        return view('funcionarios.edit')
            ->with('user', $user);
    }

    public function create()
    {
        $user = new User();
        return view('funcionarios.create')
            ->with('user', $user);
    }

    public function store(Request $request)
    {
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
            Storage::delete('public/fotos/' . $user->user->url_foto);
            $path = $request->foto->store('public/fotos');
            $user->url_foto = basename($path);
        }

        $user->save();

        return redirect()->route('admin.funcionarios')
            ->with('alert-msg', 'Funcionario "' . $user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(User $disciplina)
    {
    }
}

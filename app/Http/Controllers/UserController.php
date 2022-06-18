<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function admin_index(Request $request)
    {

        $pesquisa = $request->query('pesquisa', '');
        $users = User::where(function ($query) use ($pesquisa) {
            $query->where('name', 'like', '%' . $pesquisa . '%')
                ->orWhere('email', 'like', '%' . $pesquisa . '%');
        })
            ->where(function ($query) {
                $query->where("tipo", 'A')
                    ->orWhere("tipo", 'F');
            })
            ->get();


        return view('funcionarios.admin')
            ->with('users', $users)
            ->with('pesquisa', $pesquisa);
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

        $validated_data = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'tipo' => 'required|in:A,F',
        ]);
        $newUser = new User;
        $newUser->fill($validated_data);
        $newUser->password = Hash::make('123');
        if ($request->hasFile('foto')) {
            $path = $request->foto->store('public/fotos');
            $newUser->foto_url = basename($path);
        }
        $newUser->save();

        return redirect()->route('admin.funcionarios')
            ->with('alert-msg', 'Funcionários "' . $validated_data['name'] . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
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

            Storage::delete('public/fotos/' . $user->foto_url);

            $path = $request->foto->store('public/fotos');

            $user->foto_url = basename($path);
        }

        $user->save();

        return redirect()->route('admin.funcionarios')
            ->with('alert-msg', 'Funcionários "' . $user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function bloquiar_desbloquiar(Request $request, User $user)
    {
        if(Auth::user()->name == $user->name){
            return redirect()->route('admin.funcionarios')
                ->with('alert-msg', 'Não é possivel bloquiar a sua propria conta!')
                ->with('alert-type', 'danger');
        }
        $validated_data = $request->validate([
            'bloqueado' => 'required|in:0,1',
        ]);

        $user->fill($validated_data);

        $user->save();
        if ($request->bloqueado == '1') {
            return redirect()->route('admin.funcionarios')
                ->with('alert-msg', 'Utilizador "' . $user->name . '" foi bloquiado com sucesso!')
                ->with('alert-type', 'success');
        } else {
            return redirect()->route('admin.funcionarios')
                ->with('alert-msg', 'Utilizador "' . $user->name . '" foi desbloquiado com sucesso!')
                ->with('alert-type', 'success');
        }
    }

    public function destroy(User $user)
    {
        if(Auth::user()->name == $user->name){
            return redirect()->route('admin.funcionarios')
                ->with('alert-msg', 'Não é possivel eliminar a sua propria conta!')
                ->with('alert-type', 'danger');
        }
        $oldName = $user->name;
        $oldUrlFoto = $user->foto_url;
        try {
            $user->delete();
            Storage::delete('public/fotos/' . $oldUrlFoto);
            return redirect()->route('admin.funcionarios')
                ->with('alert-msg', 'Funcionarios "' . $user->name . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.funcionarios')
                    ->with('alert-msg', 'Não foi possível apagar o Funcionários "' . $oldName . '", porque este funcionário está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.funcionarios')
                    ->with('alert-msg', 'Não foi possível apagar o Funcionários "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }
}

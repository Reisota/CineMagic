<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

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
        
        $validated_data = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'tipo' => 'required|in:A,F',
        ]);
        $newUser = new User;
        $newUser->fill($validated_data);
        $newUser->password = Hash::make('123');
        if ($request->hasFile('foto')) {
           // $path = $request->foto->store('public/fotos');
            //$newUser->foto_url = basename($path);
            
        }
        $newUser->save();
       
        return redirect()->route('admin.funcionarios')
            ->with('alert-msg', 'Funcionarios "' . $validated_data['name'] . '" foi criado com sucesso!')
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
         
            $oldUrlFoto = $user->foto_url;
            Storage::delete('public/fotos/' . $oldUrlFoto);
            //$path = $request->file('foto')->store('public/fotos/');
            //$path= Storage::putFile('public/fotos',$request->file('foto'));
            //$user->foto_url = basename($path);
        }

        $user->save();

        return redirect()->route('admin.funcionarios')
            ->with('alert-msg', 'Funcionario "' . $user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(User $user)
    {
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
                    ->with('alert-msg', 'Não foi possível apagar o Funcionario "' . $oldName . '", porque este funcionario está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.funcionarios')
                    ->with('alert-msg', 'Não foi possível apagar o Funcionario "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }
}






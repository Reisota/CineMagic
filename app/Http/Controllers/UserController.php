<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;

class UserController extends Controller
{
    public function admin_index(Request $request)
    {
        $users = User::where("tipo", 'A')
        ->orWhere("tipo", 'F')
        ->get();

        return view('funcionarios.admin')
        ->with('users',$users);
        
    }


    public function edit(User $user)
    {
  
        $user = User::findOrFail($user->id);

        return view('funcionarios.edit')
        ->with('user',$user);
    }

    public function create()
    {
      
    }

    public function store(Request $request)
    {
       
    }

    public function update(Request $request, User $disciplina)
    {
        
    }

    public function destroy(User $disciplina)
    {
        
    }
}

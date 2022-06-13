<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Http\Requests\ClientePost;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::all();

        return view('clientes.index')
        ->with('clientes',$clientes);
    }

    public function edit(Cliente $clientes)
    {
        return view('clientes.edit')
        ->with('clientes',$clientes);
    }
  
}
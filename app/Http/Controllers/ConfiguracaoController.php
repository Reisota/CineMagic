<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function admin_index(Request $request)
    {
        $bilhete = Configuracao::all()->first();

        return view('configuracao.admin')
            ->with('bilhete', $bilhete);
    }


    public function update(Request $request)
    {
        $bilhete = Configuracao::all()->first();

        $validated_data = $request->validate([

            'preco_bilhete_sem_iva' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'percentagem_iva' => 'required|integer|min:0|max:100',
        ]);
        $bilhete->fill($validated_data);

        $bilhete->save();

        return redirect()->route('admin.configuracao')
            ->with('alert-msg', 'Preço dos bilhetes alterado com sucesso!')
            ->with('alert-type', 'success');
    }
}

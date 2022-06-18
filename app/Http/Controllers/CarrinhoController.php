<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Filme;
use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Sessao;
use App\Models\Lugar;

class CarrinhoController extends Controller
{
    public function addToCart(Request $request,$id)
    {
        $validated_data = $request->validate([
            'lugar' => 'required',
        ]);
        $sessao = Sessao::findOrFail($id);
        
        $lugar = Lugar::findOrFail($request->lugar);
        $sala = Sala::findOrFail($lugar->sala_id);
        $filme = Filme::findOrFail($sessao->filme_id);
        $cart = session()->get('cart', []);
  
        if(!isset($cart[$request->lugar])) {
            $cart[$request->lugar] = [
                "lugar_id" =>$lugar->id,
                "lugar" => $lugar->fila .$lugar->posicao,
                "sala" => $sala->nome,
                "data_hora" => $sessao->data . ' '. $sessao->horario_inicio,
                "sessao_id" => $sessao->id,
                "filme" => $filme->titulo,
                "filme_url" => $filme->cartaz_url,
            ];
        }
          
        session()->put('cart', $cart);
 
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        $configuracao = Configuracao::all()->first();
        return view('carrinho.index')
        ->with('preco',number_format($configuracao->preco_bilhete_sem_iva*(1+$configuracao->percentagem_iva/100),2));
    }


    public function remove($id)
    {
        if(isset($id)) {
            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->route('carrinho');;
    }
}

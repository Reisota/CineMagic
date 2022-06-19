<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Cliente;
use App\Models\Lugar;
use App\Models\Sala;
use App\Models\User;
use App\Models\Recibo;
use Illuminate\Http\Request;
use App\Models\Configuracao;
use Illuminate\Support\Facades\Auth;

class BilheteController extends Controller
{
    public function verificacao_index(Request $request)
    {
        $filmes = Filme::pluck('titulo', 'id');
        $filme =  $request->query('filme', new Filme());

        if ($request->filme != '' && $request->sala != '') {
            $sessao_escolhida=new Sessao();
            if($request->sessao != ''){
                $sessao_escolhida = Sessao::findOrFail($request->sessao);
            }
            $filme = Filme::findOrFail($request->filme);

            $sala = Sala::findOrFail($request->sala);
            $salas = Sala::pluck('nome', 'id');
            $sessoes = Sessao::where('filme_id', $request->filme)
                ->where('data', '>=', date("Y-m-d"))
                ->where('sala_id', $request->sala)
                ->get();
            $bilhete = new Bilhete();
            return view('funcionarios.controloAcesso')
                ->with('sala', $sala)
                ->with('salas', $salas)
                ->with('filmes', $filmes)
                ->with('sessao_escolhida',$sessao_escolhida)
                ->with('sessoes',$sessoes)
                ->with('bilhete', $bilhete)
                ->with('filme', $filme);
        }

        if ($request->filme != '') {

            $filme = Filme::findOrFail($request->filme);
            $salas = Sala::pluck('nome', 'id');



            return view('funcionarios.controloAcesso')
                ->with('sessao_escolhida', '')
                ->with('sala', new Sala())
                ->with('salas', $salas)
                ->with('filmes', $filmes)
                ->with('filme', $filme);
        }

        return view('funcionarios.controloAcesso')
            ->with('filmes', $filmes)
            ->with('filme', $filme);
    }


    public function verificacao(Request $request, Sessao $sessao)
    {
        $validated_data = $request->validate([
            'bilhete_id' => 'required|integer',
        ]);
        $filmes = Filme::pluck('titulo', 'id');
        $filme = Filme::findOrFail($sessao->filme_id);
        $sessoes = Sessao::where('filme_id', $filme->id)
            ->where('data', '>=', date("Y-m-d"))
            ->get();
        $salas = Sala::pluck('nome', 'id');

        $verificarBihete = Bilhete::find($validated_data['bilhete_id']);

        $cliente = User::Find($verificarBihete->cliente_id);

        $lugar = Lugar::Find($verificarBihete->lugar_id);

        $sala = Sala::Find($lugar->sala_id);

        if ($verificarBihete->sessao_id == $sessao->id) {
            return view('funcionarios.controloAcesso')
                ->with('bilhete', $verificarBihete)
                ->with('sessao_escolhida', $sessao)
                ->with('sessoes', $sessoes)
                ->with('filmes', $filmes)
                ->with('filme', $filme)
                ->with('cliente', $cliente)
                ->with('lugar', $lugar)
                ->with('sala', $sala)
                ->with('salas', $salas)
                ->with('valido', true);
        }
        return view('funcionarios.controloAcesso')
            ->with('bilhete', $verificarBihete)
            ->with('sessao_escolhida', $sessao)
            ->with('sessoes', $sessoes)
            ->with('filmes', $filmes)
            ->with('filme', $filme)
            ->with('sala', $sala)
            ->with('salas', $salas)
            ->with('valido', false);
    }



    public function update(Request $request, Bilhete $bilhete)
    {
        $bilhete->estado = 'usado';
        $bilhete->save();

        return redirect()->back()
        ->with('status', 'Bilhete foi usado com sucesso!');

    }


    public function addToCart(Request $request,$id)
    {
        $validated_data = $request->validate([
            'lugar' => 'required',
        ]);
        $sessao = Sessao::findOrFail($id);
        
        $lugar = Lugar::findOrFail($request->lugar);
        $sala = Sala::findOrFail($lugar->sala_id);

        $bilhetes = Bilhete::where('sessao_id',$sessao->id)->pluck('lugar_id', 'id')->toArray();
        if(in_array($lugar->id, $bilhetes)){
            return redirect()->back()->with('erro', 'O lugar não está disponivel!');
        }

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
 
        return redirect()->back()->with('status', 'Adicionado ao carrinho com sucesso!');
    }

    public function carrinho()
    {
        $configuracao = Configuracao::all()->first();
        return view('carrinho.index')
        ->with('preco',number_format($configuracao->preco_bilhete_sem_iva*(1+$configuracao->percentagem_iva/100),2));
    }


    public function removeCart($id)
    {
        if(isset($id)) {
            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->route('carrinho');
    }

    public function finalizar_compra(Request $request)
    {
        
        $cart = session()->get('cart');

        $cliente = Cliente::Find(Auth::id());
      
        if($cliente->nif==null || $cliente->ref_pagamento==null || $cliente->tipo_pagamento==null){
            return redirect()->route('carrinho')
            ->with('erro', 'Não foi possivel finalizar a compra pois os seus dados não estão compretamente preenchido! Para os preencher vá ao seu perfil de utilizador');
        }
        $configuracao = Configuracao::all()->first();
        $newRecibo = new Recibo();
        $newRecibo->cliente_id=Auth::id();
        $newRecibo->data=date("Y-m-d");
        $total_sem_iva = $configuracao->preco_bilhete_sem_iva*sizeof($cart);

      
        $total = number_format($configuracao->preco_bilhete_sem_iva*(1+$configuracao->percentagem_iva/100),2)*sizeof($cart);
     
        $newRecibo->preco_total_sem_iva=$total_sem_iva;
        $newRecibo->iva=$total-$total_sem_iva;
        $newRecibo->preco_total_com_iva=$total;
        $newRecibo->nif=$cliente->nif;
        $newRecibo->nome_cliente=Auth::user()->name;
        $newRecibo->tipo_pagamento=$cliente->tipo_pagamento;
        $newRecibo->ref_pagamento=$cliente->ref_pagamento;
        $newRecibo->recibo_pdf_url=null;
        $newRecibo->save();
        foreach($cart as $bilhete){
            
            $newBilhete = new Bilhete();
            $newBilhete->recibo_id=$newRecibo->id;
            $newBilhete->cliente_id=Auth::id();
            $newBilhete->sessao_id= $bilhete['sessao_id'];
            $newBilhete->lugar_id=$bilhete['lugar_id'];
            $newBilhete->preco_sem_iva=$configuracao->preco_bilhete_sem_iva;
            $newBilhete->save();

           
            unset($cart[$bilhete['lugar_id']]);
               
            
        }
        session()->put('cart', $cart);
        return redirect()->route('carrinho')
            ->with('status', 'Compra finalizada com successo!');
    }
}

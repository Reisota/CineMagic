@extends('layouts.app')

@section('content')
@if(session('cart'))
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Filme</th>
            <th style="width:10%" class="text-center">Sala</th>
            <th style="width:10%" class="text-center">Lugar</th>
            <th style="width:10%" class="text-center">Data e hora</th>
            <th style="width:10%" class="text-center">Preço</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>

        

        @foreach(session('cart') as $id => $details)

        <tr>
            <td>
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="{{$details['filme_url'] ? asset('storage/cartazes/' . $details['filme_url']) : asset('img/cartaz_default.png') }}" width="100" height="100" class="img-responsive" /></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{$details['filme']}}</h4>
                    </div>
                </div>
            </td>
            <td class="text-center">{{$details['sala']}}</td>
            <td class="text-center">
                {{$details['lugar']}}
            </td>
            <td class="text-center">{{$details['data_hora']}}</td>
            <td data-th="Subtotal" class="text-center">{{$preco}}</td>
            <td class="text-center">
                <form action="{{route('remove.from.cart', ['id' => $details['lugar_id']])}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                </form>
            </td>
        </tr>
        @endforeach
       
        
       
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">
                <h3><strong>Total {{$preco*sizeof(session('cart'))}}€</strong></h3>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('filmes') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Ver mais filmes</a>
                @if(Auth::user())
                <button class="btn btn-success">Finalizar Compra</button>
                @else
                <a href="{{ url('login') }}" class="btn btn-success"><i class="fa fa-angle-left"></i> Para finalizar a compra faça login com a sua conta</a>
                @endif
            </td>
        </tr>
    </tfoot>
</table>
@else
<div class="text-center"><h2>O seu carrinho está vazio</h2></div>
<div class="text-center">  <a href="{{ url('filmes') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Procurar filmes</a></div>
@endif
@endsection
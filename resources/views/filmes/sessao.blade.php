@extends('layouts.app')

@section('content')

<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    @if (session('erro'))
    <div class="alert alert-danger" role="alert">
        {{ session('erro') }}
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6">
                    <div class="white-box text-center"><img src="{{$filme->cartaz_url ? asset('storage/cartazes/' . $filme->cartaz_url) : asset('img/cartaz_default.png') }}" style="width:100%" class="img-responsive"></div>
                    <h3 class="box-title mt-5">Sessões</h3>
                    <ul class="list-unstyled">
                        @foreach ($sessoes as $sessao)
                        <a href="{{ route('sessao',['id' => $sessao->id]) }}">
                            <li>
                                Dia: {{date('d',strtotime($sessao->data))}} -
                                {{$sessao->horario_inicio}}


                            </li>
                        </a>


                        @endforeach


                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6">
                    <h3 class="box-title mt-5">{{$filme->titulo}}</h3>
                    <p>Genero: {{$genero[0]->nome}}</p>
                    <p>{{$filme->sumario}}</p>

                    <h3 class="box-title mt-5">Sessão</h3>

                    <div class="form-row">

                        <div class="col-md-3 mb-3">
                            <label for="data">Dia:</label>

                            <input type="text" class="form-control" id="data" name="data" value="{{$sessao_escolhida->data}}" disabled>

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora">Hora:</label>
                            <input type="text" class="form-control" id="hora" name="hora" value="{{$sessao_escolhida->horario_inicio}}" disabled>
                        </div>

                    </div>
                    <h3 class="box-title mt-5">Sala: {{$sala->nome}}</h3>

                    <h3 class="box-title mt-5">Lugares</h3>
                    <p>Cinzento: lugares disponiveis, Vermelho: lugares indisponiveis, Verde: lugares escolhidos por si</p>
                    <div class="table-responsive">
                        <table class="table">
                            @foreach($lugares as $lugar)

                            @if($lugar->posicao == 1)
                            <tr>
                                @endif
                                @if (in_array($lugar->id, $bilhetes))
                                <td style="background-color: #f50000;"> {{$lugar->fila}}{{$lugar->posicao}}</td>
                                @elseif(session('cart') && array_key_exists($lugar->id, session('cart')))
                                <td style="background-color: #45fa3e;"> {{$lugar->fila}}{{$lugar->posicao}}</td>
                                @else
                                <td style="background-color: #d9d4c7;"> {{$lugar->fila}}{{$lugar->posicao}}</td>
                                @endif

                                @if($lugar->posicao == $nPosicaoPorFila)
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                    <h4 class="box-title mt-5">Preço: {{$preco}}€ </h4>
                    <form method="get" action="{{route('add.to.cart',['id' => $sessao->id])}}" class="form-group" enctype="multipart/form-data">
                        @csrf
                        <select id="lugar" name="lugar" class="form-control">
                            <option value="">Selecionar lugar</option>
                            @foreach ($lugares_disponiveis as $lugar)
                            <option value="{{$lugar->id}}">
                                {{$lugar->fila}}{{$lugar->posicao}}
                            </option>
                            @endforeach
                        </select>
                        @error('lugar')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                        <br>
                        <button class="btn btn-primary" type="submit">Adicionar ao Carrinho</button>


                </div>

            </div>

        </div>
    </div>
</div>
@endsection
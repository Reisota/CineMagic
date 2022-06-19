@extends('layouts.app')
@section('content')
<div class="container">
    <h2>FILMES EM EXIBIÇÃO</h2>
    <form action="#" method="GET">
        <div class="form-row">

            <div class="col-md-3 mb-3">
                <label for="genero">Genero:</label>
                <select id="genero" name="genero" class="form-control">
                    <option value="">Selecionar genero</option>
                    @foreach ($generos as $code => $nome)
                    <option value="{{$code}}" {{$genero == $code ? 'selected' : ''}}>
                        {{$nome}}
                    </option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-6 mb-3">

                <label for="pesquisa">Pesquisar por:</label>
                <input type="text" class="form-control" id="pesquisa" name="pesquisa" placeholder="Escreva algo" value="{{$pesquisa}}">

            </div>
            <div class="col-md-4 mb-3">
                <button class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach ($filmes as $filme)
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card">
                <img src="{{$filme->cartaz_url ? asset('storage/cartazes/' . $filme->cartaz_url) : asset('img/cartaz_default.png') }}" alt="cartaz">


                <div class="card-body">

                    <h5 class="card-title"><a class="nav-link" href="{{ route('info',['id' => $filme->id]) }}">{{$filme->titulo}}</a></h5>
                    <p class="card-text">{{$filme->sumario}}</p>
                    <p class="card-text">Sessões: @foreach ($filme->sessoes as $sessao)
                        @if($sessao->data >= date("Y-m-d"))
                        dia: {{date('d/m',strtotime($sessao->data))}} -
                        {{$sessao->horario_inicio}},
                        @endif

                        @endforeach
                    </p>
                </div>
            </div>
        </div>
        @endforeach







    </div>
    @endsection
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-9">
            <form method="GET" action="{{route('verificacao')}}" class="form-group">
                <div class="form-row">

                    <div class="col-md-6 mb-3">
                        <label for="filme">Filme:</label>
                        <select id="filme" name="filme" class="form-control">
                            <option value="">Selecionar filme</option>
                            @foreach ($filmes as $id => $titulo)
                            <option value="{{$id}}" {{$filme->id == $id ? 'selected' : ''}}>
                                {{$titulo}}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    @if(isset($filme->id))
                    <div class="col-md-6 mb-3">
                        <label for="sala">Sala:</label>
                        <select id="sala" name="sala" class="form-control">
                            <option value="">Selecionar sala</option>
                            @foreach ($salas as $id => $nome)
                            <option value="{{$id}}" {{$sala->id == $id ? 'selected' : ''}}>
                                {{$nome}}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    @endif
                    @if(isset($sala->id))
                    <div class="col-md-4 mb-3">
                        <label for="sessao">Sessão:</label>
                        <select id="sessao" name="sessao" class="form-control">
                            <option value="">Selecionar sessão</option>
                            @foreach ($sessoes as $sessao)
                            <option value="{{$sessao->id}}" {{(isset($sessao_escolhida->id)) && $sessao->id == $sessao_escolhida->id ? 'selected' : ''}}>
                                Dia: {{$sessao->data}} Hora: {{$sessao->horario_inicio}}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    @endif
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-primary" type="submit">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
        @if(isset($filme->id))

        @csrf
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6">
                <label for="">Cartaz:</label>
                <div class="white-box text-center">
                    <img src="{{$filme->cartaz_url ? asset('storage/cartazes/' . $filme->cartaz_url) : asset('img/cartaz_default.png') }}" style="width:100%" class="img-responsive">
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6">

                <br>
                <h4>{{$filme->titulo}}</h4>
                <br>
                @if(isset($sessao_escolhida->id))
                <h4>Sala:</h4>
                <p>{{$sala->nome}}</p>
                <br>
                <h4>Sessão:</h4>
                <p>Dia: {{$sessao_escolhida->data}} Hora: {{$sessao_escolhida->horario_inicio}}</p>
                <br>
                <form method="GET" action="{{route('verificacao.sessao',['sessao' => $sessao_escolhida])}}" class="form-group">
                    
                    <div class="input-group">
                        <input type="text" class="form-control" id="bilhete_id" name="bilhete_id" value="{{$bilhete->id}}" placeholder="Codigo do bilhete">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Verificar Bilhete</button>
                        </div>
                    </div>
                    @error('bilhete_id')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </form>
                @endif


                @if(isset($valido))
                @if($valido == true)
                <h4>Informações do bilhete</h4>
                <p>Titulo do filme: {{$filme->titulo}}</p>
                <p>Dia: {{$sessao->data}} Hora: {{$sessao->horario_inicio}}</p>
                <p>Lugar: {{$lugar->fila}}{{$lugar->posicao}}</p>
                <p>Cliente:</p>
                <p>Nome: {{$cliente->name}} </p>
                <p>Estado:</p>
                @if($bilhete->estado == 'não usado')

                <p>Não Usado</p>
                <form method="POST" action="{{route('verificacao.edit',['bilhete' => $bilhete])}}" class="form-group">
                    @csrf
                    @method('PUT')
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Usar Bilhete</button>
                    </div>
                </form>
                @else
                <div class="alert-danger">
                    <p>Usado</p>
                </div>
     
                @endif
                @else
                <div class="alert-danger">
                    <h4>Bilhete invalido</h4>
                </div>
                @endif

                @endif
            </div>

        </div>

        @endif
    </div>
</div>
@endsection
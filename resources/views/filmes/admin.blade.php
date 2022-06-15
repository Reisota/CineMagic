@extends('layout_admin')
@section('title','Filmes' )
@section('content')
<div class="row mb-3">
    <div class="col-3">

        <a href="{{route('admin.filmes.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo Filme</a>

    </div>
    
    <div class="col-9">
        <form method="GET" action="{{route('admin.filmes')}}" class="form-group">
            <div class="input-group">
                
                <input type="text" class="form-control" id="pesquisa" value='{{$pesquisa}}' name="pesquisa" placeholder="Escreva algo">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>Genero</th>
            <th>ano</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($filmes as $filme)
        <tr {{$filme->titulo ? 'class=table-success' : ''}}>
            <td>
                <img src="{{$filme->cartaz_url ? asset('storage/cartazes/' . $filme->cartaz_url) : asset('img/cartaz_default.png') }}" alt="Foto" class="img-profile rounded-circle" style="width:40px;height:40px">
            </td>
            <td>{{$filme->titulo}}</td>
            <td>{{$filme->genero->nome}}</td>
            <td>{{$filme->ano}}</td>
            <td>
                <a href="{{route('admin.filmes.edit', ['filme' => $filme])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
            </td>
            <td>
                <a href="{{route('admin.sessoes', ['filme' => $filme])}}" class="btn btn-success btn-sm" role="button" aria-pressed="true">Sessões</a>
            </td>
            <td>
         
                <form action="{{route('admin.filmes.destroy', ['filme' => $filme])}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                </form>
        
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
@extends('layout_admin')
@section('title','Salas' )
@section('content')
<div class="row mb-3">
    <div class="col-3">

        <a href="{{route('admin.salas.create')}}" class="btn btn-success" role="button" aria-pressed="true">Nova Sala</a>

    </div> 
    <div class="col-9">
        <form method="GET" action="{{route('admin.salas')}}" class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" id="pesquisa" name="pesquisa" value='{{$pesquisa}}' placeholder="Escreva algo">
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
            <th>Nome</th>
      
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salas as $sala)
        <tr {{$sala->nome ? 'class=table-success' : ''}}>

            <td>{{$sala->nome}}</td>
            <td>
                <a href="{{route('admin.salas.edit', ['sala' => $sala])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
            </td>
            <td>
         
                <form action="{{route('admin.salas.destroy', ['sala' => $sala])}}" method="POST">
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
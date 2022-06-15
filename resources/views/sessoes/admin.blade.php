@extends('layout_admin')
@section('title','Sessões do Filme' )
@section('content')
<h3>{{$filme->titulo}}</h3>
<br>
<div class="row mb-3">
    <div class="col-3">

        <a href="{{route('admin.sessoes.create', ['filme' => $filme])}}" class="btn btn-success" role="button" aria-pressed="true">Nova Sessão</a>

    </div>

    <div class="col-9">
        <form method="GET" action="{{route('admin.sessoes', ['filme' => $filme])}}" class="form-group">
            <div class="input-group">


                <input id="startDate" class="form-control" type="date" name="data" value='{{$data}}'/>
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
            <th>Data</th>
            <th>Hora</th>
            <th>Sala</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sessoes as $sessao)
        <tr {{$sessao->data ? 'class=table-success' : ''}}>

            <td>{{$sessao->data}}</td>

            <td>{{$sessao->horario_inicio}}</td>
            <td>{{$sessao->sala->nome}}</td>
            <td>
                <a href="{{route('admin.sessoes.edit', ['sessao' => $sessao])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
            </td>
            <td>

                <form action="{{route('admin.sessoes.destroy', ['sessao' => $sessao])}}" method="POST">
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
@extends('layout_admin')
@section('title','Utilizadores' )
@section('content')
<div class="row mb-3">
    <div class="col-3">

        <a href="{{route('admin.utilizadores.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo Funcionario</a>

    </div>
    <div class="col-9">
        <form method="GET" action="{{route('admin.utilizadores')}}" class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" id="pesquisa" name="pesquisa" placeholder="Escreva algo">
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
            <th>Email</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr {{$user->name ? 'class=table-success' : ''}}>
            <td>
                <img src="/storage/fotos/{{$user->foto_url}}" alt="Foto" class="img-profile rounded-circle" style="width:40px;height:40px">
            </td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>@if($user->tipo == 'A') Administrador @else Funcionario @endif</td>
            <td>

                <a href="{{route('admin.utilizadores.edit', ['user' => $user])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>

            </td>
            <td>
         
                <form action="{{route('admin.utilizadores.destroy', ['user' => $user])}}" method="POST">
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
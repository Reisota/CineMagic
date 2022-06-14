@extends('layout_admin')
@section('title','Clientes' )
@section('content')
<div class="row mb-3">
    <div class="col-3">


    </div>
    <div class="col-9">
        <form method="GET" action="{{route('admin.clientes')}}" class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" id="pesquisa"  value='{{$pesquisa}}' name="pesquisa" placeholder="Escreva algo">
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
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr {{$user->name ? 'class=table-success' : ''}}>
            <td>
                <img src="{{$user->foto_url ? asset('storage/fotos/' . $user->foto_url) : asset('img/default_img.png') }}" alt="Foto" class="img-profile rounded-circle" style="width:40px;height:40px">
            </td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>

            <td>
                <form method="POST" action="{{route('admin.clientes.bloquiar_desbloquiar', ['user' => $user]) }}">
                    @csrf
                    @method('PUT')
                    @if($user->bloqueado == 0)
                    <button class="btn btn-danger btn-sm" type="submit" name="bloqueado" value="1">Bloquiar Conta</button>
                    @else
                    <button class="btn btn-danger btn-sm" type="submit" name="bloqueado" value="0">Desbloquiar Conta</button>
                    @endif
                </form>
            </td>
            <td>

                <form action="{{route('admin.clientes.destroy', ['user' => $user])}}" method="POST">
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
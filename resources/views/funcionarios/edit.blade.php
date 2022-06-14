@extends('layout_admin')
@section('title','Alterar Funcionário' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.funcionarios.update', ['user' => $user]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            @include('funcionarios.partials.create-edit')
            <br>
            <button class="btn btn-primary" type="submit">Guardar Alterações</button>

        </div>

</div>
</form>
<form method="POST" action="{{route('admin.funcionarios.bloquiar_desbloquiar', ['user' => $user]) }}" class="form-group">
    @csrf
    @method('PUT')
    @if($user->bloqueado == 0)
    <button class="btn btn-danger" type="submit" name="bloqueado" value="1">Bloquiar Conta</button>
    @else
    <button class="btn btn-danger" type="submit" name="bloqueado" value="0">Desbloquiar Conta</button>
    @endif
</form>

</div>

@endsection
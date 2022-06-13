@extends('layouts.app')
@section('title','Alterar Cliente' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('clientes.update', ['user' => $user]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
        @include('clientes.partials.create-edit')
                <br>
                <button class="btn btn-primary" type="submit">Guardar Alterações</button>
            </div>

        </div>
    </form>
</div>

@endsection





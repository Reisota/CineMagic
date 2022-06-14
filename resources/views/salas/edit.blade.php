@extends('layout_admin')
@section('title','Alterar Sala' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.salas.update', ['sala' => $sala]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            @include('salas.partials.create-edit')
            <br>
            <button class="btn btn-primary" type="submit">Guardar Alterações</button>

        </div>

</div>
</form>

@endsection

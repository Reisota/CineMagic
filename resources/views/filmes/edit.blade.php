@extends('layout_admin')
@section('title','Alterar Filme' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.filmes.update', ['filme' => $filme]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            @include('filmes.partials.create-edit')
            <br>
            <button class="btn btn-primary" type="submit">Guardar Alterações</button>

        </div>
    </form>
    </div>
</div>


@endsection
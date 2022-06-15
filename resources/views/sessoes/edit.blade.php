@extends('layout_admin')
@section('title','Alterar Sessão' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.sessoes.update', ['sessao' => $sessao]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            @include('sessoes.partials.create-edit')
            <br>
            <button class="btn btn-primary" type="submit">Guardar Alterações</button>

        </div>
    </form>
    </div>
</div>


@endsection
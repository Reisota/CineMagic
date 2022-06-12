@extends('layout_admin')
@section('title','Alterar Funcionario' )
@section('content')
<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
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
</div>

@endsection
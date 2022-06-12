@extends('layout_admin')
@section('title','Alterar Utilizador' )
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
            <div class="col-lg-5 col-md-5 col-sm-6">
                <label for="">Foto:</label>
                <div class="white-box text-center"><img src="/storage/fotos/{{$user->foto_url}}" style="width:100%" class="img-responsive"></div>
                <p><input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;"></p>
                <p><label class="btn btn-secondary" for="file">Escolher Foto</label></p>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6">
                <br>
                <label>Nome:</label>
                <input type="text" class="form-control" id="nome" name="name" value="{{ $user->name}}">
                @error('nome')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
                <br>
                <label>Email:</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email}}">
                @error('email')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
                <br>
                <label>Função:</label>
                <select id="tipo" class="form-control" name="tipo">

                    <option value="F" {{$user->tipo == 'F' ? 'selected' : ''}}>Funcionario</option>
                    <option value="A" {{$user->tipo == 'A' ? 'selected' : ''}}>Administrador</option>
                </select>
                @error('tipo')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
                <br>
                <button class="btn btn-primary" type="submit">Guardar Alterações</button>
            </div>

        </div>
    </form>
</div>

@endsection
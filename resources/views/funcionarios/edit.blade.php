@extends('layout_admin')
@section('title','Alterar Utilizador' )
@section('content')
<form>
        <div class="text-center">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" value="{{ $user->name}}">

            <br>
            <label for="">id:</label>

            <input type="text" class="form-control" id="email" value="{{ $user->email}}">

            <br>
            <input type="text" class="form-control" id="tipo" value="{{ $user->tipo}}">
            <br>
            <label for="">Foto:</label>
            <br>


            <p><img id="output" src="/storage/fotos/{{$user->foto_url}}" alt="picture" class="img-fluid" style="width:15%" /></p>

            <script>
                var loadFile = function(event) {
                    var image = document.getElementById('output');
                    image.src = URL.createObjectURL(event.target.files[0]);
                };
            </script>
            <p><input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;"></p>
            <p><label class="btn btn-secondary" for="file">Escolher Foto</label></p>



        </div>

        <div class="text-center">
            <br>
            <br>
            <button class="btn btn-primary" type="submit">Guardar Alterações</button>
        </div>

    </forms>
    
@endsection

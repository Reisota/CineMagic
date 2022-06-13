@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Perfil </h2>
    <form>
        <div class="text-center">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" placeholder="{{ Auth::user()->name }}">

            <br>
            <label for="">id:</label>

            <input type="text" class="form-control" id="nif" placeholder="{{$clientes[Auth::user()->id]->nif}}">

            <br>
            <label for="">Metodo de pagamento:</label>
            <input type="text" class="form-control" id="pagmento" placeholder="{{$clientes[Auth::user()->id]->tipo_pagamento}}">
            <br>
            <label for="">Ref. de pagamento:</label>
            <input type="text" class="form-control" id="ref" placeholder="{{$clientes[Auth::user()->id]->ref_pagamento}}">
            <br>
            <label for="">Foto:</label>
            <br>


            <p><img id="output" src="/storage/fotos/{{Auth::user()->foto_url}}" alt="picture" class="img-fluid" style="width:15%" /></p>

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
            <a href="{{route('clientes.edit', ['clientes' => $clientes])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
        </div>

    </forms>

</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Perfil </h2>
    <form method="POST" action="{{route('clientes.update', ['user' => $user]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
        <div class="text-center">
    
            <label for="nome">Nome:</label>
            @error('name')
            <div class="alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" class="form-control" id="nome" name="name" placeholder="{{ $user->name }}">
         
            <br>
            <label for="">Nif:</label>
            @error('name')
            <div class="alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" class="form-control" id="nif" name="nif" placeholder="{{$cliente->nif}}">

            <br>
            <label for="">Metodo de pagamento:</label>
            @error('name')
            <div class="alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" class="form-control" id="pagmento" name="tipo_pagamento" placeholder="{{$cliente->tipo_pagamento}}">
            <br>
            <label for="">Ref. de pagamento:</label>
            @error('name')
            <div class="alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" class="form-control" id="ref" name="ref_pagamento" placeholder="{{$cliente->ref_pagamento}}">
            <br>
            <label for="">Foto:</label>
            <br>
            <p><img id="output" src="/storage/fotos/{{Auth::user()->foto_url}}" name="foto" alt="picture" class="img-fluid" style="width:15%" /></p>
            <script>
                var loadFile = function(event) {
                    var image = document.getElementById('output');
                    image.src = URL.createObjectURL(event.target.files[0]);
                };
            </script>
            <p><input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" name="foto" style="display: none;"></p>
            <p><label class="btn btn-secondary" for="file">Escolher Foto</label></p>

        </div>

        <div class="text-center">
            <br>
            <br>
            <button class="btn btn-primary" type="submit">Guardar Alterações</button>
            <a href="{{route('clientes.edit', ['user' => $user])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
    
        </div>

    </forms>

</div>

@endsection



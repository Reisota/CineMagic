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
                <input type="text" class="form-control" id="nome" name="name" value="{{ $user->name }}">

                <br>
                <label for="">Nif:</label>
                @error('nif')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
                <input type="text" class="form-control" id="nif" name="nif" value="{{$cliente->nif}}">
                <br>
                <label for="">Metodo de pagamento:</label>
                @error('tipo_pagamento')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
                <input type="text" class="form-control" id="pagamento" name="tipo_pagamento" value="{{$cliente->tipo_pagamento}}">
                <br>
                <label for="">Ref. de pagamento:</label>
                @error('ref_pagamento')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
                <input type="text" class="form-control" id="ref" name="ref_pagamento" value="{{$cliente->ref_pagamento}}">
                <br>

                    <label for="">Foto:</label>
                    <div class="white-box text-center">
                        <img id="output" src="{{$user->foto_url ? asset('storage/fotos/' . $user->foto_url) : asset('img/default_img.png') }}" style="width:30%" class="img-responsive">
                    </div>
                    <p><input type="file" accept="image/*" name="foto" id="file" onchange="loadFile(event)" style="display: none;"></p>
                    <p><label class="btn btn-secondary" for="file">Escolher Foto</label></p>

            </div>

            <div class="text-center">
                <br>
                <br>
                <button class="btn btn-primary" type="submit">Guardar Alterações</button>
            </div>

            </forms>

        </div>

        @endsection
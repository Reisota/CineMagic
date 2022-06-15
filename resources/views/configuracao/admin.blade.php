@extends('layout_admin')
@section('title', 'Preço bilhetes' )
@section('content')
<div class="container">
    
    <form method="POST" action="{{route('admin.configuracao.update')}}" class="form-group" >
        @csrf
        @method('PUT')

        <div class="row">
            <div class="text-center">

                <label for="nome">Preco do bilhete sem iva:</label>
            
                <input type="text" class="form-control" id="nome" name="preco_bilhete_sem_iva" value="{{ $bilhete->preco_bilhete_sem_iva }}">
                @error('preco_bilhete_sem_iva')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
                <br>
                <label for="">Valor do Iva:</label>
                
                <input type="text" class="form-control" id="nif" name="percentagem_iva" value="{{$bilhete->percentagem_iva}}">
                @error('percentagem_iva')
                <div class="alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <br>
                <br>
                <button class="btn btn-primary" type="submit">Guardar Alterações</button>
            </div>

            </forms>

        </div>

        @endsection
@extends('layout_admin')
@section('title', 'Novo Filme' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.filmes.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            @include('filmes.partials.create-edit')
            <br>
                <button class="btn btn-primary" type="submit">Criar Funcionário</button>
            </div>

        </div>
    </form>
</div>

@endsection
@extends('layout_admin')
@section('title', 'Novo Funcionário' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.salas.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @include('salas.partials.create-edit')
            <br>
                <button class="btn btn-primary" type="submit">Criar Funcionário</button>
            </div>

        </div>
    </form>
</div>

@endsection
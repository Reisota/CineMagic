@extends('layout_admin')
@section('title', 'Novo Funcionario' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.funcionarios.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @include('funcionarios.partials.create-edit')
            <br>
                <button class="btn btn-primary" type="submit">Criar Funcionario</button>
            </div>

        </div>
    </form>
</div>

@endsection
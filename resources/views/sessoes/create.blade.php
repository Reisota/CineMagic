@extends('layout_admin')
@section('title', 'Nova Sessão' )
@section('content')
<div class="container">
    <form method="POST" action="{{route('admin.sessoes.store')}}" class="form-group">
        @csrf
        <div class="row">
            @include('sessoes.partials.create-edit')
            <br>
                <button class="btn btn-primary" type="submit">Criar Sessão</button>
            </div>

        </div>
    </form>
</div>

@endsection
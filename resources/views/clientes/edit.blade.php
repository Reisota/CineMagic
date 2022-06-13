@extends('layout_admin')
@section('title','Alterar Docente' )
@section('content')
    <form method="POST" action="{{route('admin.clientes.update', ['clientes' => $clientes]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{$clientes->id}}">
        @include('clientes.partials.create-edit')
        @isset($clientes->user->foto_url)
            <div class="form-group">
                <img src="{{$clientes->user->foto_url ? asset('storage/fotos/' . $clientes->user->foto_url) : asset('img/default_img.png') }}"
                     alt="Foto do clientes"  class="img-profile"
                     style="max-width:100%">
            </div>
        @endisset
        <div class="form-group text-right">
            @isset($docente->user->foto_url)
                <button type="submit" class="btn btn-danger" name="deletefoto" form="form_delete_photo">Apagar Foto</button>
            @endisset
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('admin.clientes.edit', ['clientes' => $clientes]) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <form id="form_delete_photo" action="{{route('admin.clientes.foto.destroy', ['clientes' => $clientes])}}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection
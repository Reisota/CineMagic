@extends('layout_admin')
@section('title', 'Novo Docente' )
@section('content')
    <form method="POST" action="{{route('admin.docentes.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @include('docentes.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.docentes.create')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection

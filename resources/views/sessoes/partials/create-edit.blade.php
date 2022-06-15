<div class="col-lg-5 col-md-5 col-sm-6">
    <label for="">Cartaz:</label>
    <div class="white-box text-center">
        <img src="{{$filme->cartaz_url ? asset('storage/cartazes/' . $filme->cartaz_url) : asset('img/cartaz_default.png') }}" style="width:100%" class="img-responsive">
    </div>
</div>
<div class="col-lg-7 col-md-7 col-sm-6">
    <br>
    <h3>{{$filme->titulo}}</h3>
    <br>
    <input type="hidden" class="form-control" id="titulo" name="filme_id" value="{{$filme->id}}">
    <label>Data:</label>
    <input type="text" class="form-control" id="data" name="data" value="{{old('data',  $sessao->data)}}">
    @error('data')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    
    <br>
    <label>Horário:</label>
    <input type="text" class="form-control" id="horario_inicio" name="horario_inicio" value="{{old('horario_inicio',$sessao->horario_inicio)}}">
    @error('horario_inicio')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="genero_code">Sala:</label>
    <select id="genero_code" name="sala_id" class="form-control">
        <option value="">Selecionar sala</option>
        @foreach ($salas as $id => $nome)
        <option value="{{$id}}" {{$id == $sala->id ? 'selected' : ''}}>
            {{$nome}}
        </option>
        @endforeach
    </select>
    @error('sala_id')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
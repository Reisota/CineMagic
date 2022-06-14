<div class="col-lg-5 col-md-5 col-sm-6">
    <label for="">Cartaz:</label>
    <div class="white-box text-center">
        <img src="{{$filme->cartaz_url ? asset('storage/cartazes/' . $filme->cartaz_url) : asset('img/cartaz_default.png') }}" style="width:100%" class="img-responsive">
    </div>
    <p><input type="file" accept="image/*" name="foto" id="file" onchange="loadFile(event)" style="display: none;"></p>
    <p><label class="btn btn-secondary" for="file">Escolher Foto</label></p>
</div>
<div class="col-lg-7 col-md-7 col-sm-6">
    <br>
    <label>Titulo:</label>
    <input type="text" class="form-control" id="titulo" name="titulo" value="{{old('titulo',  $filme->titulo)}}">
    @error('nome')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="genero_code">Genero:</label>
    <select id="genero_code" name="genero_code" class="form-control">
        <option value="">Selecionar genero</option>
        @foreach ($generos as $code => $nome)
        <option value="{{$code}}" {{$code == $filme->genero_code ? 'selected' : ''}}>
            {{$nome}}
        </option>
        @endforeach
    </select>
    @error('genero_code')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <label>Sumário:</label>
    <textarea class="form-control" id="sumario" name="sumario">{{old('sumario', $filme->sumario)}}
    </textarea>
    @error('sumario')
    <div class="alert-danger">{{ $message }}</div>
    @enderror

    <br>
    <label>Ano:</label>
    <input type="text" class="form-control" id="ano" name="ano" value="{{old('ano',  $filme->ano)}}">
    @error('ano')
    <div class="alert-danger">{{ $message }}</div>
    @enderror

    <br>
    <label>Link do trailer:</label>
    <input type="text" class="form-control" id="trailer_url" name="trailer_url" value="{{old('trailer_url',  $filme->trailer_url)}}">
    @error('trailer_url')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
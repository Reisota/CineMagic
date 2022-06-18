<div class="col-lg-7 col-md-7 col-sm-6">
    <br>
    <label>Nome:</label>
    <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome',  $sala->nome)}}">
    @error('nome')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <label>Fila:</label>
    <input type="text" class="form-control" id="fila" name="fila" value="{{old('fila',  $fila)}}">
    @error('fila')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <label>Lugares:</label>
    <input type="text" class="form-control" id="posicao" name="posicao" value="{{old('posicao',  $posicao)}}">
    @error('posicao')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <br>
 
<div class="col-lg-5 col-md-5 col-sm-6">
    <label for="">Foto:</label>
    <div class="white-box text-center">
        <img id="output" src="{{$user->foto_url ? asset('storage/fotos/' . $user->foto_url) : asset('img/default_img.png') }}" style="width:100%" class="img-responsive">
    </div>
    <p><input type="file" accept="image/*" name="foto" id= "file" onchange="loadFile(event)" style="display: none;"></p>
    <p><label class="btn btn-secondary" for="file">Escolher Foto</label></p>
</div>
<div class="col-lg-7 col-md-7 col-sm-6">
    <br>
    <label>Nome:</label>
    <input type="text" class="form-control" id="nome" name="name" value="{{old('name',  $user->name)}}">
    @error('nome')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <label>Email:</label>
    <input type="text" class="form-control" id="email" name="email" value="{{ old('email',$user->email)}}">
    @error('email')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <label>Função:</label>
    <select id="tipo" class="form-control" name="tipo">

        <option value="F" {{ old('tipo',$user->tipo) == 'F' ? 'selected' : ''}}>Funcionario</option>
        <option value="A" {{ old('tipo',$user->tipo) == 'A' ? 'selected' : ''}}>Administrador</option>
    </select>
    @error('tipo')
    <div class="alert-danger">{{ $message }}</div>
    @enderror
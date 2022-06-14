<div class="col-lg-5 col-md-5 col-sm-6">

    <div class="white-box text-center"><img src="{{$filme->cartaz_url ? asset('storage/cartazes/' . $filme->cartaz_url) : asset('img/cartaz_default.png') }}" style="width:100%" class="img-responsive"></div>
</div>
<div class="col-lg-7 col-md-7 col-sm-6">
    <h3 class="box-title mt-5">{{$filme->titulo}}</h3>
    <p>Genero: {{$genero[0]->nome}}</p>
    <p>{{$filme->sumario}}</p>
    <h3 class="mt-5">
        Trailer

    </h3>
    
    <h3 class="box-title mt-5">Sessões</h3>
    <ul class="list-unstyled">
        @foreach ($sessoes as $sessao)
        <a href="{{ route('sessao',['id' => $sessao->id]) }}">
            <li>
                Dia: {{date('d',strtotime($sessao->data))}} -
                {{$sessao->horario_inicio}}


            </li>
        </a>


        @endforeach


    </ul>

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6">
                    <div class="white-box text-center"><img src="/storage/cartazes/{{$filme->cartaz_url}}" style="width:100%" class="img-responsive"></div>
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
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6">
                    <h3 class="box-title mt-5">{{$filme->titulo}}</h3>
                    <p>Genero: {{$genero[0]->nome}}</p>
                    <p>{{$filme->sumario}}</p>

                    <h3 class="box-title mt-5">Sessão</h3>

                    <div class="form-row">

                        <div class="col-md-3 mb-3">
                            <label for="data">Dia:</label>

                            <input type="text" class="form-control" id="data" name="data" value="{{$sessao_escolhida->data}}" disabled>

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hora">Hora:</label>
                            <input type="text" class="form-control" id="hora" name="hora" value="{{$sessao_escolhida->horario_inicio}}" disabled>


                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>
    @endsection
@extends('layout_admin')
@section('title', 'Estatisticas' )
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                    <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                            <a class="nav-link" href="estatisticas">{{ __('Filmes no Cinema em 2022') }}</a>
                        </li>                   
                    </ul>
                    </div>
                    <div class="card-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
           Numero Total de Filmes no cinema em 2022 : {{$totalFilmes2022}}
           <br>
           <br>
           
        </div>
            
    </div>
    <script>
        const  novaArrayLiteral = [{{$totalFilmes1}},{{$totalFilmes2}},{{$totalFilmes3}},{{$totalFilmes4}},{{$totalFilmes5}},
        {{$totalFilmes6}},{{$totalFilmes7}},{{$totalFilmes8}},{{$totalFilmes9}},{{$totalFilmes10}},{{$totalFilmes11}},{{$totalFilmes12}}];
        
      const chart = Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Filmes no cinema em 2022'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                    'Oct', 'Nov', 'Dec'
                ]
            },
            yAxis: {
                title: {
                    text: 'Filmes'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                
                name: '2022',
                data: novaArrayLiteral
            }]
        });

    </script>

@endsection
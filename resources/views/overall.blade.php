@extends('layouts.app')

@section('content')

    <ul class="nav nav-tabs">
        <li class="active"><a  href="{{ route('overall') }}">Общий статус</a></li>
        <li ><a href="{{ route('home') }}">ОТДЕЛ</a></li>
        <li><a  href="{{ route('home_m') }}">Модель</a></li>
    </ul>

    <div class="tab-content">
        <div id="telegram" class="tab-pane fade in active">
            <div class="container-fluid" >
                <div class="row">
                    <div style="text-align: right" class="col-md-12">
                        {!! Form::open(['url' => '/home', 'method'=>'get',  'class' => 'form-inline']) !!}
                        <div class="form-group">
                            <select name="year" class="form-control">
                                @foreach(range(2019,2029,1) as $item)
                                    <option value="{{ $item }}" {{ $year == $item ? 'selected="selected"' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">{!! trans('app.btn.search') !!}</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-12">
                        <div id="columnchart_material_all" ></div>
                    </div>
                    <div class="col-md-12">
                        <div id="columnchart_material" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        var telegram = <?=$telegram?>;
        var tus = <?=$tus?>;
        // console.log(tus);

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualizationm);

        function drawVisualizationm() {
            // Some raw data (not necessarily accurate)
            var teleg = [
                ['Year',  'Количество всех проблем - '+tus[0].usoni+' шт',
                    'Количество открытых проблем-'+tus[0].ochiq+' шт'],
            ];
            for (var i = 0; i<telegram.length; i++){

                var oy;
               switch (telegram[i].oylar) {
                    case 1:
                        oy = 'Январь '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                        break;
                   case 2:
                       oy = 'Февраль '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 3:
                       oy = 'Март '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 4:
                      oy =  'Апрель '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 5:
                       oy = 'Май '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 6:
                       oy = 'Июнь '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 7:
                       oy = 'Июль '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 8:
                      oy =  'Август '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 9:
                       oy = 'Сентябрь '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 10:
                      oy =  'Октябрь '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 11:
                      oy =  'Ноябрь '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
                   case 12:
                       oy = 'Декабрь '+telegram[i].muammo_soni+'('+telegram[i].holat+')'+'шт';
                       break;
               }
                teleg.push([oy, telegram[i].muammo_soni, telegram[i].holat])
            }
            var data = google.visualization.arrayToDataTable(
                teleg
            );
            var options = {
                title: 'Состояние выполнения технических отчетов',
                vAxis: {title: 'Тип рекламации - социальная сеть'},
                colors: ['green', 'red'],
                hAxis: {title: 'Месяцы'},
                'width': '33%', 'height': 400,
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('columnchart_material'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        var allproblem = <?=$allproblem?>;
        var sumproblem = <?=$sumproblem?>;
        // console.log(tus);
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualizationm);

        function drawVisualizationm() {
            // Some raw data (not necessarily accurate)
            var problem = [
                ['Year',  'Количество всех проблем - '+sumproblem[0].usoni+' шт',
                    'Количество открытых проблем-'+sumproblem[0].ochiq+' шт'],
            ];
            for (var i = 0; i<allproblem.length; i++){

                var oy;
               switch (allproblem[i].oylar) {
                    case 1:
                        oy = 'Январь '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                        break;
                   case 2:
                       oy = 'Февраль '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 3:
                       oy = 'Март '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 4:
                      oy =  'Апрель '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 5:
                       oy = 'Май '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 6:
                       oy = 'Июнь '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 7:
                       oy = 'Июль '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 8:
                      oy =  'Август '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 9:
                       oy = 'Сентябрь '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 10:
                      oy =  'Октябрь '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 11:
                      oy =  'Ноябрь '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
                   case 12:
                       oy = 'Декабрь '+allproblem[i].muammo_soni+'('+allproblem[i].holat+')'+'шт';
                       break;
               }
                problem.push([oy, allproblem[i].muammo_soni, allproblem[i].holat])
            }
            var data = google.visualization.arrayToDataTable(
                problem
            );
            var options = {
                title: 'Состояние выполнения технических отчетов',
                vAxis: {title: 'Тип рекламации  - технический отчет'},
                colors: ['green', 'red'],
                hAxis: {title: 'Месяцы'},
                'width': '33%', 'height': 400,
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('columnchart_material_all'));
            chart.draw(data, options);
        }
    </script>
@endsection
@extends('layouts.app')

@section('content')
    <?php
    function generateUrl($count, $month, $year, $status, $supplier)
    {
        return $count != 0 ? '<a href="' . url('/problems?vehicle_model_id=' . $supplier . '&month=' . $month . '&year=' . $year . '&status=' . $status) . '">' . $count . '</a>' : $count;
    }
    ?>
    <?
    //    var_dump($json_result); die();
    ?>

    <ul class="nav nav-tabs">
        <li><a  href="{{ route('overall') }}">Общий статус</a></li>
        <li ><a  href="{{ route('home') }}">ОТДЕЛ</a></li>
        <li class="active"><a  href="{{ route('home_m') }}">Модель</a></li>
    </ul>

    <div class="tab-content">
        <div id="model" class="tab-pane fade in active">
            <div class="container-fluid">
                <div style="padding-bottom: 20px" class="row">

                    <div class="col-md-12">
                        <div id="chart_divm"></div>
                    </div>

                </div>
            </div>
            <div class="container-fluid">
                <div style="padding-bottom: 20px" class="row">
                    <div class="col-md-6">
                        <div id="piechart1m"></div>
                    </div>

                    <div class="col-md-6">
                        <div id="piechart2m"></div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="table">
                    <table style="background-color: white; border-collapse: collapse; color: black"
                           class="table table-bordered">
                        <thead>
                        <tr>
                            <th colspan="24">{{ trans('app.placeholder.report') }}</th>
                            <th colspan="5" class="text-right">
                                {!! Form::open(['url' => '/home_m', 'method'=>'get',  'class' => 'form-inline']) !!}
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
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center" rowspan="2">#</th>
                            <th class="text-center" rowspan="2">{!! trans('app.menu.models') !!}</th>
                            <th class="text-center" colspan="2">{{ trans('app.Jan') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.Feb') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.March') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.April') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.May') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.June') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.July') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.Aug') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.Sep') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.Oct') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.Nov') }}</th>
                            <th class="text-center" colspan="2">{{ trans('app.Dec') }}</th>
                            <th class="text-center" colspan="3">{{ trans('app.Total') }}</th>
                        </tr>
                        <tr>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <td class="text-center"
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</td>
                            <td class="text-center"
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</td>
                            <th class=""
                                style="background-color: green; color: #FFFFFF">{!! trans('app.Closed') !!}</th>
                            <th class=""
                                style="background-color: red; color: #FFFFFF">{!! trans('app.Open') !!}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody style="font-size: 15px; text-align: center;">
                        <?php
                        $counter = 0;
                        $totals = [
                            'Jan_1' => 0,
                            'Jan_0' => 0,
                            'Feb_1' => 0,
                            'Feb_0' => 0,
                            'March_1' => 0,
                            'March_0' => 0,
                            'April_1' => 0,
                            'April_0' => 0,
                            'May_1' => 0,
                            'May_0' => 0,
                            'June_1' => 0,
                            'June_0' => 0,
                            'July_1' => 0,
                            'July_0' => 0,
                            'Aug_1' => 0,
                            'Aug_0' => 0,
                            'Sep_1' => 0,
                            'Sep_0' => 0,
                            'Oct_1' => 0,
                            'Oct_0' => 0,
                            'Nov_1' => 0,
                            'Nov_0' => 0,
                            'Dec_1' => 0,
                            'Dec_0' => 0,
                        ]
                        ?>
                        @foreach($resultsm as $row)
                            <?php
                            $totals['Jan_1'] += $row->Jan_1;
                            $totals['Jan_0'] += $row->Jan_0;
                            $totals['Feb_1'] += $row->Feb_1;
                            $totals['Feb_0'] += $row->Feb_0;
                            $totals['March_1'] += $row->March_1;
                            $totals['March_0'] += $row->March_0;
                            $totals['April_1'] += $row->April_1;
                            $totals['April_0'] += $row->April_0;
                            $totals['May_1'] += $row->May_1;
                            $totals['May_0'] += $row->May_0;
                            $totals['June_1'] += $row->June_1;
                            $totals['June_0'] += $row->June_0;
                            $totals['July_1'] += $row->July_1;
                            $totals['July_0'] += $row->July_0;
                            $totals['Aug_1'] += $row->Aug_1;
                            $totals['Aug_0'] += $row->Aug_0;
                            $totals['Sep_1'] += $row->Sep_1;
                            $totals['Sep_0'] += $row->Sep_0;
                            $totals['Oct_1'] += $row->Oct_1;
                            $totals['Oct_0'] += $row->Oct_0;
                            $totals['Nov_1'] += $row->Nov_1;
                            $totals['Nov_0'] += $row->Nov_0;
                            $totals['Dec_1'] += $row->Dec_1;
                            $totals['Dec_0'] += $row->Dec_0;
                            ?>
                            <tr>
                                <td>{{ ++$counter }}</td>
                                <th>{{ $row->name }}</th>
                                <td>{!! generateUrl($row->Jan_1, 1, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->Jan_0, 1, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->Feb_1, 2, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->Feb_0, 2, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->March_1, 3, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->March_0, 3, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->April_1, 4, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->April_0, 4, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->May_1, 5, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->May_0, 5, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->June_1, 6, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->June_0, 6, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->July_1, 7, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->July_0, 7, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->Aug_1, 8, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->Aug_0, 8, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->Sep_1, 9, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->Sep_0, 9, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->Oct_1, 10, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->Oct_0, 10, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->Nov_1, 11, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->Nov_0, 11, $year, 0, $row->id) !!}</td>

                                <td>{!! generateUrl($row->Dec_1, 12, $year, 10, $row->id) !!}</td>
                                <td>{!! generateUrl($row->Dec_0, 12, $year, 0, $row->id) !!}</td>

                                <th style="background-color: green; color: #FFFFFF"
                                    class="text-center">{{ $row->Jan_1 + $row->Feb_1 + $row->March_1 + $row->April_1 + $row->May_1 + $row->June_1 + $row->July_1 + $row->Aug_1 + $row->Sep_1 + $row->Oct_1 + $row->Nov_1 + $row->Dec_1 }}</th>
                                <th style="background-color: red; color: #FFFFFF"
                                    class="text-center">{{ $row->Jan_0 + $row->Feb_0 + $row->March_0 + $row->April_0 + $row->May_0 + $row->June_0 + $row->July_0 + $row->Aug_0 + $row->Sep_0 + $row->Oct_0 + $row->Nov_0 + $row->Dec_0 }}</th>
                                <th class="text-center">{{ $row->Jan_1 + $row->Feb_1 + $row->March_1 + $row->April_1 + $row->May_1 + $row->June_1 + $row->July_1 + $row->Aug_1 + $row->Sep_1 + $row->Oct_1 + $row->Nov_1 + $row->Dec_1 + $row->Jan_0 + $row->Feb_0 + $row->March_0 + $row->April_0 + $row->May_0 + $row->June_0 + $row->July_0 + $row->Aug_0 + $row->Sep_0 + $row->Oct_0 + $row->Nov_0 + $row->Dec_0 }}</th>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="2">{{ trans('app.Total') }}</th>
                            <td>{{ $totals['Jan_1'] }}</td>
                            <td>{{ $totals['Jan_0'] }}</td>
                            <td>{{ $totals['Feb_1'] }}</td>
                            <td>{{ $totals['Feb_0'] }}</td>
                            <td>{{ $totals['March_1'] }}</td>
                            <td>{{ $totals['March_0'] }}</td>
                            <td>{{ $totals['April_1'] }}</td>
                            <td>{{ $totals['April_0'] }}</td>
                            <td>{{ $totals['May_1'] }}</td>
                            <td>{{ $totals['May_0'] }}</td>
                            <td>{{ $totals['June_1'] }}</td>
                            <td>{{ $totals['June_0'] }}</td>
                            <td>{{ $totals['July_1'] }}</td>
                            <td>{{ $totals['July_0'] }}</td>
                            <td>{{ $totals['Aug_1'] }}</td>
                            <td>{{ $totals['Aug_0'] }}</td>
                            <td>{{ $totals['Sep_1'] }}</td>
                            <td>{{ $totals['Sep_0'] }}</td>
                            <td>{{ $totals['Oct_1'] }}</td>
                            <td>{{ $totals['Oct_0'] }}</td>
                            <td>{{ $totals['Nov_1'] }}</td>
                            <td>{{ $totals['Nov_0'] }}</td>
                            <td>{{ $totals['Dec_1'] }}</td>
                            <td>{{ $totals['Dec_0'] }}</td>
                            <th style="background-color: green;  color: white" class=" text-center">{{ $totals['Jan_1'] + $totals['Feb_1'] + $totals['March_1'] + $totals['April_1'] + $totals['May_1'] + $totals['June_1'] + $totals['July_1'] + $totals['Aug_1'] + $totals['Sep_1'] + $totals['Oct_1'] + $totals['Nov_1'] + $totals['Dec_1'] }}</th>
                            <th style="background-color: red;  color: white" class=" text-center">{{ $totals['Jan_0'] + $totals['Feb_0'] + $totals['March_0'] + $totals['April_0'] + $totals['May_0'] + $totals['June_0'] + $totals['July_0'] + $totals['Aug_0'] + $totals['Sep_0'] + $totals['Oct_0'] + $totals['Nov_0'] + $totals['Dec_0'] }}</th>
                            <th style="text-align: center" colspan="2">
                                {{ $totals['Jan_1'] + $totals['Feb_1'] + $totals['March_1'] + $totals['April_1'] + $totals['May_1'] + $totals['June_1'] + $totals['July_1'] + $totals['Aug_1'] + $totals['Sep_1'] + $totals['Oct_1'] + $totals['Nov_1'] + $totals['Dec_1'] + $totals['Jan_0'] + $totals['Feb_0'] + $totals['March_0'] + $totals['April_0'] + $totals['May_0'] + $totals['June_0'] + $totals['July_0'] + $totals['Aug_0'] + $totals['Sep_0'] + $totals['Oct_0'] + $totals['Nov_0'] + $totals['Dec_0'] }}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">

        var valueem = <?=$json_resultm?>;
        // Load google charts
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart1m);

        // Draw the chart and set the chart values
        function drawChart1m() {
            var arrr = [
                ['Ответственный отдел', 'Отк'],
            ];
            for (var i = 0; i < valueem.length; i++) {
                arrr.push([valueem[i].nomi+' ('+valueem[i].sum2+' шт)', valueem[i].sum2])
            }
            var data = google.visualization.arrayToDataTable(
                arrr
            );

            // Optional; add a title and set the width and height of the chart
            var options = {'title': ' Состояние открытых проблем', 'width': '33%', 'height': 400};

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart1m'));
            chart.draw(data, options);
        }


        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualizationm);

        function drawVisualizationm() {
            // Some raw data (not necessarily accurate)
            var zm = 0;
            var om = 0;
            for (var i = 0; i < valueem.length; i++) {
                zm += valueem[i].sum1;
                om += valueem[i].sum2;
            }
            var arr = [
                ['Ответственный sasa отдел', 'Зак '+zm, 'Отк '+om],
            ];
            for (var i = 0; i < valueem.length; i++) {
                arr.push([valueem[i].nomi+' '+valueem[i].sum1+'('+valueem[i].sum2+')', valueem[i].sum1, valueem[i].sum2])
            }
            var data = google.visualization.arrayToDataTable(
                arr
            );
            var options = {
                title: 'Состояние выполнения технических отчетов',
                vAxis: {title: 'Зак, Отк'},
                colors: ['green', 'red'],
                hAxis: {title: 'Модель'},
                'width': '33%', 'height': 400,
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('chart_divm'));
            chart.draw(data, options);
        }

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart2m);

        // Draw the chart and set the chart values
        function drawChart2m() {
            var arrrr = [
                ['Ответственный отдел', 'Зак'],
            ];
            for (var i = 0; i < valueem.length; i++) {
                arrrr.push([valueem[i].nomi+' ('+valueem[i].sum1+' шт)', valueem[i].sum1])
            }
            var data = google.visualization.arrayToDataTable(
                arrrr
            );

            // Optional; add a title and set the width and height of the chart
            var options = {'title': ' Состояние закрытых проблем', 'width': '33%', 'height': 400};

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart2m'));
            chart.draw(data, options);
        }
    </script>
@endsection
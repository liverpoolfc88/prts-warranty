@extends('layouts.app')
<style>
    .customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        -webkit-box-shadow: 2px 2px 15px 0px #02010F;
        box-shadow: 2px 2px 15px 0px #02010F;
    }
    .customers td, .customers th {
        border: 1px #96B4D8 solid;
        padding: 1px 8px;
        font-size: 15px;
    }
    .customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .customers tr:hover {
        background-color: #ddd;
    }
    .customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #CEE2F7;
        color: white;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }

    thead {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
</style>
@section('content')
<div class="container">
<div class="row">
    <table id="resultTable" class="customers ">
        <thead>
            <tr>
                <th>
                    <a href="">T/r</a>

                </th>
                <th>
                    <a href="{{ url('group_problem',['sort'=>'depname']) }}">Ответственный отдел</a>
                </th>
                <th>
                    <a href="{{ url('group_problem',['sort'=>'defname']) }}">Дефект</a>
                </th>
                <th>
                    <a href="{{ url('group_problem',['sort'=>'kod']) }}">Код дефекта</a>
                </th>
                <th>
                    <a href="{{ url('group_problem',['sort'=>'lfname']) }}">Дeфeктная часть 1</a>
                </th>
                <th>
                    <a href="{{ url('group_problem',['sort'=>'lsname']) }}">Дeфeктная часть 2</a>
                </th>
                <th>
                    <a href="{{ url('group_problem',['sort'=>'vmname']) }}"> &nbsp; Модель &nbsp; </a>
                </th>
                <th>
                    <a href="{{ url('group_problem',['sort'=>'soni']) }}">Количество</a>
                </th>

            </tr>
        </thead>
        <tbody>
        @foreach($model as $key => $m)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $m->depname }}</td>
                <td>{{ $m->defname }}</td>
                <td>{{ $m->kod }}</td>
                <td>{{ $m->lfname }}</td>
                <td>{{ $m->lsname }}</td>
                <td>{{ $m->vmname }}</td>
                <td>{{ $m->soni }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
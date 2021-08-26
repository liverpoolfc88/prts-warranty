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
    <a  type="button" id="type" class=" btn btn-success">Tanla</a>
    <a href="{{ url('shows') }}" type="button" style="margin-bottom: 20px" class="btn btn-success">KO`PROQ</a>
{{--    <h5>{{ session('idd')  }}</h5>--}}
{{--    <h5>{{ session('ids')  }}</h5>--}}
<div class="row">
    <table id="resultTable" class="customers ">
        <thead>
            <tr>
                <th>
                    <a href="">T/r</a>
                </th>
                <th>
                    <a href="">ID</a>
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
{{--                <th>--}}
{{--                    <a href="{{ url('group_problem',['sort'=>'soni']) }}">Количество</a>--}}
{{--                </th>--}}

            </tr>
        </thead>
        <tbody>
        @foreach($problems as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td><button id="{{ $item->id }}" data="1" class="select btn btn-primary">{{ $item->id }}</button></td>
                <td>{{ $item->department ? $item->department->name : '' }}</td>
                <td>{{ !empty($item->fault_type) ? $item->fault_type->name : '' }}</td>
                <td>{{ !empty($item->fault_type) ? $item->fault_type->kod : '' }}</td>
                <td>{{ !empty($item->level_second->level->name) ? $item->level_second->level->name: '' }}</td>
                <td>{{ !empty($item->level_second) ? $item->level_second->name: '' }}</td>
                <td>{{ $item->vehicleModel->name }}</td>
{{--                <td>{{ $m->soni }}</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function () {
        var ids = [];
        var idd = <?=$id;?>;
        var sel = true;
        $('.select').click(function () {
            var data = $(this).attr('data');
            if (data == '1'){
                // $(this).css("background-color", "red");
                var id = $(this).attr('id');
                $('#'+id).css("background-color", "red");
                $(this).attr('data','0');

                // id = id.toString();
                // id = parseInt(id);
                ids.push(id);
                console.log(ids);
            }
            else {
                // $(this).css("background-color", "#3097D1");
                var id = $(this).attr('id');
                $('#'+id).css("background-color", "#3097D1");
                var indx = ids.indexOf(id);
                if (indx > -1){
                    ids.splice(indx,1);
                }
                $(this).attr('data','1');
                console.log(ids);
            }
            // alert('sasas');



                console.log(idd);

            $.get("{!! Url::to('select') !!}", {ids: ids, idd:idd}, function (response) {

                console.log(response);

                if (response == "success") {
                    // alert('сообщение отправлено');
                }

            })
        })
    })
</script>
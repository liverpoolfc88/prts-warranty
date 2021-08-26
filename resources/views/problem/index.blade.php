<?php
/**
 * Created by PhpStorm.
 * User: MSherali
 * Date: 08.11.2017
 * Time: 8:02
 */
?>
<? $y = date('Y'); $year = [
     $y - 2 => $y - 2, $y - 1 => $y - 1, $y => $y, $y + 1 => $y + 1, $y + 2 => $y + 2
]; ?>
<style>
    select {
        margin-bottom: 10px !important;
    }

    input {
        margin-bottom: 10px !important;
    }
</style>
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2>
            {{ trans('app.problem.header') }}
            <span class="pull-right">
                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\User::ROLE_EMPLOYEE && \Illuminate\Support\Facades\Auth::user()->hasRole('admin') )
                    <a href="{{ url('/problems/create') }}" class="btn btn-success">{!! trans('app.btn.create') !!}</a>
                @endif
            </span>
        </h2>
        <div class="panel panel-footer text-right">
            {!! Form::open(['url' => '/problems', 'method'=>'GET',  'class' => 'form-inline']) !!}

            {!! Form::text('id', old('id'), ['class' => 'form-control mb-2 mr-sm-2', 'style' => 'width:100px', 'placeholder' => trans('app.messages.search.enter_id')]) !!}

            <select name="current_stage_id" class="form-control mb-2 mr-sm-2">
                <option value="">{{ trans('app.placeholder.stages') }}</option>
                @foreach($filter as $group)
                    <optgroup label="{{ $group->title}}">
                        @foreach($group->stages as $stage)
                            <option value="{{ $stage->id }}" {{ app('request')->input('current_stage_id') == $stage->id ? 'selected="selected"' : '' }}>
                                {{ $stage->title }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            @if(\Illuminate\Support\Facades\Auth::user()->role == \App\User::ROLE_EMPLOYEE)
                {!! Form::select('department_id', \App\Department::pluck('name','id')->prepend(trans('app.placeholder.departments'),''), old('department_id'), ['class' => 'form-control mb-2 mr-sm-2']) !!}
            @endif

            {!! Form::select('problem_type_id', \App\ProblemType::pluck('name','id')->prepend(trans('app.placeholder.types'),''), old('problem_type_id'), ['class' => 'form-control mb-2 mr-sm-2']) !!}
            {!! Form::select('vehicle_model_id', \App\VehicleModel::pluck('name','id')->prepend(trans('app.placeholder.models'),''), old('vehicle_model_id'), ['class' => 'form-control mb-2 mr-sm-2']) !!}
            {!! Form::select('dealer_id', \App\Dealer::pluck('name','id')->prepend(trans('app.placeholder.dealers'),''), old('dealer_id'), ['class' => 'form-control mb-2 mr-sm-2']) !!}
            <select class="change form-control mb-2 mr-sm-2">
                <option value="" selected="selected">{{trans('app.level1.header')}}</option>
                <? foreach (\App\Level_first::all() as $key =>$val){?>
                <option value="<?=$val->id?>"><?=$val->name?></option>
                <? } ?>
            </select>
            <select name="level_second_id" id="levelsecond" class="form-control mb-2 mr-sm-2">
                <option value="" selected="selected">{{trans('app.level2.header')}}</option>
            </select>
            <!--            --><?// var_dump($request); die();?>

            {!! Form::select('created_at',$year, old('created_at'), ['class' => 'form-control mb-2 mr-sm-2', 'style' => 'width:120x', 'placeholder' => trans('app.messages.search.year')]) !!}
            {!! Form::text('description', old('description'), ['class' => 'form-control mb-2 mr-sm-2', 'style' => 'width:120x', 'placeholder' => trans('app.messages.search.description')]) !!}
            {!! Form::text('part_type', old('part_type'), ['class' => 'form-control mb-2 mr-sm-2', 'style' => 'width:120x', 'placeholder' => trans('app.messages.search.part_type')]) !!}
            {!! Form::text('vin', old('vin'), ['class' => 'form-control mb-2 mr-sm-2', 'style' => 'width:120px', 'placeholder' => trans('app.messages.search.vin')]) !!}
            {!! Form::select('fault_type_id', \App\Fault_type::pluck('kod','id')->prepend(trans('app.fault_type.kod'),''), old('fault_type_id'), ['class' => 'form-control mb-2 mr-sm-2']) !!}

            {!! Form::select('region_id', \App\Region::pluck('name','id')->prepend(trans('app.placeholder.regions'),''), old('region_id'), ['class' => 'form-control mb-2 mr-sm-2']) !!}


            {!! Form::select('status', [''=>trans('app.placeholder.statuses'), \App\Problem::STATUS_OPEN => trans('app.problem.status_'.\App\Problem::STATUS_OPEN), \App\Problem::STATUS_CLOSE => trans('app.problem.status_'.\App\Problem::STATUS_CLOSE) ], old('status'), ['class' => 'form-control mb-2 mr-sm-2']) !!}

            {{--@role('employee')--}}
            <a style="margin-bottom: 10px" href="{{ url('/report_p') }}"
               class="btn btn-primary form-control">{!! trans('app.btn.report') !!}</a>
            {{--@endcan--}}

            <button style="margin-bottom: 10px" type="submit"
                    class="btn btn-info">{!! trans('app.btn.search') !!}</button>

            {!! Form::close() !!}
        </div>


        <div class="table">
            <table class="table table-bordered table-hover" data-toggle="dataTable" data-form="deleteForm">
                <thead>
                <tr>
                    <th>@sortablelink('description', trans('app.problem.id'))</th>
                    <th>@sortablelink('description', trans('app.problem.description'))</th>
{{--                    <th>@sortablelink('part_type', trans('app.problem.part_type'))</th>--}}

                    <th>@sortablelink('description', trans('app.problem.level_first'))</th>
                    <th>@sortablelink('level_second.name', trans('app.problem.level_second'))</th>
                    {{--                    <th>@sortablelink('part_number', trans('app.problem.part_number'))</th>--}}
                    <th>@sortablelink('fault_type.name', trans('app.fault_type.kod'))</th>
                    <th>@sortablelink('vehicleModel.name', trans('app.vehicleModel.name'))</th>
                    <th>@sortablelink('vin', trans('app.problem.vin'))</th>
                    <th>@sortablelink('dealer.name', trans('app.dealer.name'))</th>
                    <th>@sortablelink('region.name', trans('app.region.name'))</th>
                    <th>@sortablelink('problemType.name', trans('app.problem.problem_type_id'))</th>
                    <th>@sortablelink('created_at', trans('app.created_at'))</th>
                    <th>@sortablelink('department.name', trans('app.problem.department_id'))</th>
                    <th>@sortablelink('stage.title', trans('app.stage.title'))</th>
                    {{--                    <th>@sortablelink('stage.title', trans('app.stage.time'))</th>--}}
                    <th>@sortablelink('status', trans('app.problem.status'))</th>
                    @role('admin')
                    <th colspan="2">{!! trans('app.btn.actions') !!}</th>
                    @endrole
                </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($model as $key => $item)
                    {{--*/$x++;/*--}}
                    <tr class="active">
                        <td>{{ $item->id }}</td>
                        @if($shart)
                            <th>{!! $item->description !!}</th>
                        @else
                            <th><a href="{{ url('problems', $item->id) }}">{!! $item->description !!}</a></th>
                        @endif

{{--                        <td>{{ $item->part_type }}</td>--}}

                        <td>{{ !empty($item->level_second->level->name) ? $item->level_second->level->name: '' }}</td>
                        <td>{{ !empty($item->level_second) ? $item->level_second->name: '' }}</td>
                        {{--                        <td>{{ $item->part_number }}</td>--}}
                        <td>{{ !empty($item->fault_type) ? $item->fault_type->name.'-'.$item->fault_type->kod : '' }}</td>
                        <td>{{ $item->vehicleModel->name }}</td>
                        <td>{{ $item->vin }}</td>
                        <td>{{ $item->dealer->name }}</td>
                        <td>{{ $item->region ? $item->region->name : '' }}</td>
                        <td>{{ $item->problemType->name }}</td>
                        <td>{{ $item->created_at }}</td>
                        @if($shart)
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    {{ $item->department ? $item->department->name : '' }}
                                </button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h1>Вы уверены, что деталь доставлена?</h1>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="ok" data-id="{{ $item->id }}" type="button" class="btn btn-primary" data-dismiss="modal">Доставлено</button>
{{--                                                <button type="button" class="btn btn-primary">Доставлено</button>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @else
                            <td>{{ $item->department ? $item->department->name : '' }}</td>
{{--                            <td>{{ $item->department ? $item->department->name : '' }}</td>--}}
                        @endif
{{--                        <td>{{ $item->department ? $item->department->name : '' }}</td>--}}
                        <td>{{ $item->stage ? $item->stage->title : '' }}</td>

                        <?
                        $item_time = strtotime($item->created_at);
                        $time = time();
//                        $item_date = date('d', $time - $item_time) - 1;
                        $item_date =  round(($time-$item_time)/60/60/24);
                        $dat = date("Y-m-d H:i:s", time() - 86400);
                        //                        $date_create = new DateTime($item->created_at);
                        //                        $date_create = $date_create->format('d');
                        //                        $date = date();
                        //                        $d=$date-$date_create

                        if (($item->created_at > $dat) && ($item->status == \App\Problem::STATUS_OPEN)){?>
                        <td>
                            <span class="pull-right label label-danger success">
                                <marquee width="100%" direction="up">
                                {{ trans('app.problem.status_'.$item->status) }} <br> <h4 align="center">new</h4>
                                </marquee>
                            </span>
                            <p align="center"><?='Прошло ' . $item_date . ' дней'?></p>
                        </td>
                        <? }  else {?>
                        <td>
                            <span class="pull-right label label-{{ $item->status == \App\Problem::STATUS_OPEN ? 'danger' : 'success' }} success">
                                {{ trans('app.problem.status_'.$item->status) }}
                            </span>
                            <p><?=$item->status == \App\Problem::STATUS_OPEN ? 'Прошло ' . $item_date . ' дней' : ''?></p>
                        </td>
                        <? } ?>
                        @role('admin')
                        <td>
                            <a href="{{ url('/problems/' . $item->id . '/edit') }}"
                               style="margin-bottom: 5px"
                               class="btn btn-primary btn-xs">{!! trans('app.btn.update') !!}</a>
                            {!! Form::model($item, ['method' => 'delete', 'url' => ['/problems', $item->id], 'class' =>'form-delete', 'style'=>'display:inline']) !!}
                            {!! Form::hidden('id', $item->id) !!}
                            {!! Form::button(trans('app.btn.delete'), ['type' => 'submit', 'data-title'=>trans('app.messages.header.delete'), 'data-message'=>trans('app.stageGroup.messages.delete'), 'class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                            {!! Form::close() !!}
                        </td>
                        {{--                        <td><i class="fa fa-pencil"></i></td>--}}
                        @endrole
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--            <div class="pagination"> {!! $model->render() !!} </div>--}}
            <div class="pagination">  {{ $model->appends($data)->links() }}</div>
        </div>

    </div>
@endsection
@section('scripts')
    var tmpl = $.templates('
    <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
            <div class="caption">
                <h4 class="group inner list-group-item-heading">\{\{:department.name\}\}
                    <span class="pull-right">
                        \{\{:problemType.name\}\}
                    </span>
                </h4>
                <p class="group inner list-group-item-text">
                    \{\{:description\}\}
                <h4 class="group inner list-group-item-heading">
                    \{\{:stage.title\}\}
                </h4>
            </div>
        </div>
    </div>');

    var person = {department: {name:"Uz DY"}, problemType: {name: "DRR"}, description: "Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.", stage: {title: "Program created"}};

    // Render template for person object
    var html = tmpl.render(person); // ready for insertion, e.g $("#result").html(html);

    //$('#products').append(html);

    // result: "Name: Jim<br/> "
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(function () {
        $('#ok').click(function (){
        // alert('sasa');
            var id = $(this).attr('data-id');
            // var id = 6;
            // alert(id);
            $.get("{!! Url::to('delivery') !!}", { id:id}, function (response) {

                console.log(response);

                location.reload();

                // if (response == "success") {
                //     alert('сообщение отправлено');
                // }

            })
        })
        $(document).on('change', '.change', function () {
            // alert();
            var id = $(this).val();
            console.log(id);
            $.ajax({
                type: 'get',
                url: '{!! Url::to('levelsecond') !!}',
                data: {id: id},
                success: function (data) {
                    $('select#levelsecond').find('option').remove().end();
                    $.each(data, function (key, value) {
                        $('select#levelsecond').append('<option value="' + value.id + '">' + value.name + '</option>')
                    })
                    // window.location.reload();
                },
                error: function () {
                    console.log(error);
                }
            });

        });
    })
</script>


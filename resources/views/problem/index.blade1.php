<?php
/**
 * Created by PhpStorm.
 * User: MSherali
 * Date: 08.11.2017
 * Time: 8:02
 */
?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>
            {{ trans('app.problem.header') }}
            <span class="pull-right">
                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\User::ROLE_EMPLOYEE && \Illuminate\Support\Facades\Auth::user()->hasRole('admin') )
                    <a href="{{ url('/problems/create') }}" class="btn btn-success">{!! trans('app.btn.create') !!}</a>
                @endif
            </span>
        </h2>
        <div class="panel panel-footer text-right">
            {!! Form::open(['url' => '/problems', 'method'=>'get',  'class' => 'form-inline']) !!}

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

                {!! Form::select('region_id', \App\Region::pluck('name','id')->prepend(trans('app.placeholder.regions'),''), old('region_id'), ['class' => 'form-control mb-2 mr-sm-2']) !!}


                {!! Form::select('status', [''=>trans('app.placeholder.statuses'), \App\Problem::STATUS_OPEN => trans('app.problem.status_'.\App\Problem::STATUS_OPEN), \App\Problem::STATUS_CLOSE => trans('app.problem.status_'.\App\Problem::STATUS_CLOSE) ], old('status'), ['class' => 'form-control mb-2 mr-sm-2']) !!}

            {{--@role('employee')--}}
                <a href="{{ url('/report_p') }}" class="btn btn-primary form-control">{!! trans('app.btn.report') !!}</a>
            {{--@endcan--}}

            <button type="submit" class="btn btn-info">{!! trans('app.btn.search') !!}</button>

            {!! Form::close() !!}
        </div>

        <div class="table">
            <table class="table table-bordered table-hover" data-toggle="dataTable" data-form="deleteForm">
                <thead>
                <tr>
                    <th>@sortablelink('description', trans('app.problem.description'))</th>
                    <th>@sortablelink('part_number', trans('app.problem.part_number'))</th>
                    <th>@sortablelink('vehicleModel.name', trans('app.vehicleModel.name'))</th>

                    <th>@sortablelink('vin', trans('app.problem.vin'))</th>
                    <th>@sortablelink('dealer.name', trans('app.dealer.name'))</th>
                    <th>@sortablelink('region.name', trans('app.region.name'))</th>
                    <th>@sortablelink('problemType.name', trans('app.problem.problem_type_id'))</th>
                    <th>@sortablelink('created_at', trans('app.created_at'))</th>

                    <th>@sortablelink('department.name', trans('app.problem.department_id'))</th>
                    <th>@sortablelink('stage.title', trans('app.stage.title'))</th>
                    <th>@sortablelink('status', trans('app.problem.status'))</th>
                    @role('admin')
                        <th>{!! trans('app.btn.actions') !!}</th>
                    @endrole
                </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($data as $item)
                    {{--*/$x++;/*--}}
                    <tr class="active">
                        <th><a href="{{ url('problems', $item->id) }}">{!! $item->description !!}</a></th>
                        <td>{{ $item->part_number }}</td>
                        <td>{{ $item->vehicleModel->name }}</td>
                        <td>{{ $item->vin }}</td>
                        <td>{{ $item->dealer->name }}</td>
                        <td>{{ $item->region ? $item->region->name : '' }}</td>
                        <td>{{ $item->problemType->name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->department ? $item->department->name : '' }}</td>
                        <td>{{ $item->stage ? $item->stage->title : '' }}</td>
                        <td><span class="pull-right label label-{{ $item->status == \App\Problem::STATUS_OPEN ? 'danger' : 'success' }} success">{{ trans('app.problem.status_'.$item->status) }}</span></td>

                        @role('admin')
                            <td>
                                {!! Form::model($item, ['method' => 'delete', 'url' => ['/problems', $item->id], 'class' =>'form-delete', 'style'=>'display:inline']) !!}
                                {!! Form::hidden('id', $item->id) !!}
                                {!! Form::button(trans('app.btn.delete'), ['type' => 'submit', 'data-title'=>trans('app.messages.header.delete'), 'data-message'=>trans('app.stageGroup.messages.delete'), 'class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endrole
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination"> {!! $data->render() !!} </div>
        </div>

    </div>
@endsection


@section('scripts')
    var tmpl = $.templates('<div class="item  col-xs-4 col-lg-4"><div class="thumbnail"><div class="caption"><h4 class="group inner list-group-item-heading">\{\{:department.name\}\}<span class="pull-right">\{\{:problemType.name\}\}</span></h4><p class="group inner list-group-item-text">\{\{:description\}\}</p><h4 class="group inner list-group-item-heading">\{\{:stage.title\}\}</h4></div></div></div>');

    var person = {department: {name:"Uz DY"}, problemType: {name: "DRR"}, description: "Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.", stage: {title: "Program created"}};

    // Render template for person object
    var html = tmpl.render(person); // ready for insertion, e.g $("#result").html(html);

    //$('#products').append(html);

    // result: "Name: Jim<br/> "
@endsection
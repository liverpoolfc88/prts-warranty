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
        <div class="row">
            {{--@include('patient._search')--}}
            <div class="col-md-6">
                <h1>{{ trans('app.user.header') }} </h1>
            </div>
                @role('admin')
            <div style="padding-top: 20px; display: flex; align-items: center" class="col-md-6">
                <form style="display: flex; align-items: center" method="get" action="{{ url('/users') }}">
                    <input placeholder="поиск..." style="width: unset; margin-right: 20px" class="form-control mb-2 mr-sm-2" name="name">
                    <button style="margin-right: 20px" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
                <a href="{{ url('/users/create') }}" class="btn btn-success pull-right btn-sm">{!! trans('app.btn.create') !!}</a>
            </div>
                @endcan
        </div>
        <div class="table">
            <table class="table table-bordered table-hover" data-toggle="dataTable" data-form="deleteForm">
                <thead>
                <tr>
                    <th>@sortablelink('id', trans('app.id'))</th>
                    <th>@sortablelink('name', trans('app.user.name'))</th>
                    <th>@sortablelink('email', trans('app.user.email'))</th>
                    <th>@sortablelink('phone_number', trans('app.user.phone_number'))</th>
                    <th>{{ trans('app.problem.department_id') }}</th>
                    <th>@sortablelink('role', trans('app.user.role'))</th>
                    <th>{!! trans('app.btn.actions') !!}</th>
                </tr>
                </thead>
                <tbody>
<!--                --><?// var_dump($data[0]); die(); ?>
                {{-- */$x=0;/* --}}
                @foreach($data as $item)
                     {{--*/$x++;/*--}}
                    <tr class="active">
                        <td>{{ $item->id }}</td>
                        <th><a href="{{ url('users', $item->id) }}">{{ $item->name }}</a></th>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone_number }}</td>
                        <td>
<!--                            --><?// var_dump($item->departments); ?>
                            @foreach($item->departments as $department)
                                <span class="label label-info"> {{ $department->name }} </span>
                            @endforeach
                        </td>
                        <td>{{ trans('app.user.role_'.$item->role) }}</td>
                        <td>
                            @role('admin')
                            <a href="{{ url('/users/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">{!! trans('app.btn.update') !!}</a>
                            {!! Form::model($item, ['method' => 'delete', 'url' => ['/users', $item->id], 'class' =>'form-delete', 'style'=>'display:inline']) !!}
                            {!! Form::hidden('id', $item->id) !!}
                            {!! Form::button(trans('app.btn.delete'), ['type' => 'submit', 'data-title'=>trans('app.messages.header.delete'), 'data-message'=>trans('app.user.messages.delete'), 'class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                            {!! Form::close() !!}
                            @endrole
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pagination"> {!! $data->render() !!} </div>
        </div>

    </div>
@endsection

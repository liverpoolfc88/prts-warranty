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

        </div>

        <h1>{{ trans('app.level1.header') }}
            @role('admin')
            <a href="{{ url('/level1/create') }}"
               class="btn btn-success pull-right btn-sm">{!! trans('app.btn.create') !!}</a>
            @endcan
        </h1>

        <div class="table">
            <table class="table table-bordered table-hover" data-toggle="dataTable" data-form="deleteForm">
                <thead>
                <tr>
                    <th>@sortablelink('id', trans('app.id'))</th>
                    <th>@sortablelink('name', trans('app.level1.name'))</th>
                    <th>{!! trans('app.btn.actions') !!}</th>
                </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($data as $item)
                    {{--*/$x++;/*--}}
                    <tr class="active">
                        <td>{{ $item->id }}</td>
                        <th><a href="{{ url('level1', $item->id) }}">{{ $item->name }}</a></th>
                        <td>
                            @role('admin')
                            <a href="{{ url('/level1/' . $item->id . '/edit') }}"
                               class="btn btn-primary btn-xs">{!! trans('app.btn.update') !!}</a>

                            {!! Form::model($item, ['method' => 'delete', 'url' => ['/level1', $item->id], 'class' =>'form-delete', 'style'=>'display:inline']) !!}
                            {!! Form::hidden('id', $item->id) !!}
                            {!! Form::button(trans('app.btn.delete'), ['type' => 'submit', 'data-title'=>trans('app.messages.header.delete'), 'data-message'=>trans('app.level1.messages.delete'), 'class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
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

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


        <h1>{{ trans('app.dealer.header') }}
            @role('admin')
                <a href="{{ url('/dealers/create') }}" class="btn btn-success pull-right btn-sm">{!! trans('app.btn.create') !!}</a>
            @endcan
        </h1>

        <div class="table">
            <table class="table table-bordered table-hover" data-toggle="dataTable" data-form="deleteForm">
                <thead>
                <tr>
                    <th>@sortablelink('id', trans('app.id'))</th>
                    <th>@sortablelink('name', trans('app.dealer.name'))</th>
                    <th>@sortablelink('address', trans('app.dealer.address'))</th>
                    <th>@sortablelink('contact', trans('app.dealer.contact'))</th>
                    <th>{!! trans('app.btn.actions') !!}</th>
                </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($data as $item)
                     {{--*/$x++;/*--}}
                    <tr class="active">
                        <td>{{ $item->id }}</td>
                        <th><a href="{{ url('dealers', $item->id) }}">{{ $item->name }}</a></th>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->contact }}</td>
                        <td>
                            @role('admin')
                            <a href="{{ url('/dealers/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">{!! trans('app.btn.update') !!}</a>

                            {!! Form::model($item, ['method' => 'delete', 'url' => ['/dealers', $item->id], 'class' =>'form-delete', 'style'=>'display:inline']) !!}
                            {!! Form::hidden('id', $item->id) !!}
                            {!! Form::button(trans('app.btn.delete'), ['type' => 'submit', 'data-title'=>trans('app.messages.header.delete'), 'data-message'=>trans('app.dealer.messages.delete'), 'class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
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

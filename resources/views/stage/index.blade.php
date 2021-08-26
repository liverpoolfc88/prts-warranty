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


        <h1>{{ trans('app.stage.header') }}
            @role('admin')
                <a href="{{ url('/stages/create') }}" class="btn btn-success pull-right btn-sm">{!! trans('app.btn.create') !!}</a>
            @endcan
        </h1>

        <div class="table">
            <table class="table table-bordered table-hover" data-toggle="dataTable" data-form="deleteForm">
                <thead>
                <tr>
                    <th>{{ trans('app.id') }}</th>

                    <th>{{ trans('app.stageGroup.title') }}</th>
                    <th>{{ trans('app.stage.title') }}</th>
                    <th>{{ trans('app.stage.sequence') }}</th>
                    <th>{{ trans('app.stage.has_action') }}</th>
                    <th>{{ trans('app.stage.has_date') }}</th>
                    <th>{{ trans('app.stage.has_attachment') }}</th>
                    <th>{{ trans('app.stage.has_approval') }}</th>
                    <th>{{ trans('app.stage.owner') }}</th>

                    <th>{!! trans('app.btn.actions') !!}</th>
                </tr>
                </thead>
                <tbody>
                <?php $group_seq=0; $stage_seq=0; ?>
                @foreach($data as $item)
                    <tr class="active">
                        {{--<td>{{ $item->id }}</td>--}}
                        <td>{{ ++$group_seq }}</td>
                        <th colspan="8"><a href="{{ url('stage-groups', $item->id) }}">{{ $item->title }}</a></th>
                        <td></td>
                    </tr>
                     @foreach($item->stages as $stage)
                         <tr>
                             <td></td>
                             {{--<td>{{ $stage->id }}</td>--}}
                             <td>{{ ++$stage_seq }}</td>
                             <td><a href="{{ url('stages', $stage->id) }}">{{ $stage->title }}</a></td>
                             <td>{{ $stage->sequence }}</td>
                             <td class="text-center">{!! $stage->has_action ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                             <td class="text-center">{!! $stage->has_date ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                             <td class="text-center">{!! $stage->has_attachment ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                             <td class="text-center">{!! $stage->has_approval ? '<i class="fa fa-check-circle text-success"></i>' : '<span class="text-muted"><i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                             <td>{{ trans('app.user.role_'.$stage->owner) }}</td>
                             <td>
                                 @role('admin')
                                     <a href="{{ url('/stages/' . $stage->id . '/edit') }}" class="btn btn-primary btn-xs">{!! trans('app.btn.update') !!}</a>

                                     {!! Form::model($stage, ['method' => 'delete', 'url' => ['/stages', $stage->id], 'class' =>'form-delete', 'style'=>'display:inline']) !!}
                                     {!! Form::hidden('id', $stage->id) !!}
                                     {!! Form::button(trans('app.btn.delete'), ['type' => 'submit', 'data-title'=>trans('app.messages.header.delete'), 'data-message'=>trans('app.stage.messages.delete'), 'class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                                     {!! Form::close() !!}
                                 @endrole
                             </td>
                         </tr>
                     @endforeach
                @endforeach
                </tbody>
            </table>

            <div class="pagination"> {!! $data->render() !!} </div>
        </div>

    </div>
@endsection

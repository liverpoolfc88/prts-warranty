@extends('layouts.app')

@section('content')
<div class="container">

    <h1>
        {{ $model->title }}
        <a href="{{ url('/stages/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">{!! trans('app.btn.update') !!}</a>
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <td>{{ $model->id }}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.stageGroup.title') }} </th>
                    <td><a href="{{ url('stageGroup', $model->stageGroup->id) }}">{{ $model->stageGroup->title }}</a></td>
                </tr>
                <tr>
                    <th> {{ trans('app.stage.title') }} </th>
                    <td> {{ $model->title }} </td>
                </tr>
                <tr>
                    <th> {{ trans('app.stage.sequence') }} </th>
                    <td> {{ $model->sequence }} </td>
                </tr>
                <tr>
                    <th> {{ trans('app.stage.has_action') }} </th>
                    <td> {!! $model->has_action ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.stage.has_date') }} </th>
                    <td> {!! $model->has_date ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.stage.has_attachment') }} </th>
                    <td> {!! $model->has_attachment ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.stage.has_approval') }} </th>
                    <td> {!! $model->has_approval ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.stage.has_attachment') }} </th>
                    <td> {!! $model->has_attachment ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="{{ url('/stages') }}" class="btn btn-default btn-xs pull-right">{!! trans('app.btn.back') !!}</a>

</div>
@endsection
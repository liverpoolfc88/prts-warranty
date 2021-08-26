@extends('layouts.app')

@section('content')
<div class="container">

    <h1>
        {{ $model->title }}
        <a href="{{ url('/stage-groups/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">{!! trans('app.btn.update') !!}</a>
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
                    <td> {{ $model->title }}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.stageGroup.sequence') }} </th>
                    <td> {{ $model->sequence }} </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <th>{{ trans('app.stage.title') }}</th>
                    <th>{{ trans('app.stage.sequence') }}</th>
                    <th>{{ trans('app.stage.has_action') }}</th>
                    <th>{{ trans('app.stage.has_date') }}</th>
                    <th>{{ trans('app.stage.has_attachment') }}</th>
                    <th>{{ trans('app.stage.has_approval') }}</th>
                    <th>{{ trans('app.stage.owner') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model->stages as $stage)
                    <tr>
                        <td>{{ $stage->id }}</td>
                        <td><a href="{{ url('stages', $stage->id) }}">{{ $stage->title }}</a></td>
                        <td>{{ $stage->sequence }}</td>
                        <td class="text-center">{!! $stage->has_action ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                        <td class="text-center">{!! $stage->has_date ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                        <td class="text-center">{!! $stage->has_attachment ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                        <td class="text-center">{!! $stage->has_approval ? '<i class="fa fa-check-circle text-success"></i>' : '<span class="text-muted"><i class="fa fa-minus-circle text-danger"></i>' !!}</td>
                        <td>{{ trans('app.user.role_'.$stage->owner) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ url('/stage') }}" class="btn btn-default btn-xs pull-right">{!! trans('app.btn.back') !!}</a>

</div>
@endsection
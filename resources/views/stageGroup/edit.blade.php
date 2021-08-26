@extends('layouts.app')

@section('content')
<div class="container">

    <h1>{{ trans('app.stageGroup.header.edit') }}</h1>
    <hr/>

    {!! Form::model($model, [
        'method' => 'PATCH',
        'id' =>'form-stage-group',
        'url' => ['/stage-groups', $model->id],
        'class' => 'form-horizontal'
    ]) !!}

    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
        {!! Form::label('title', trans('app.stageGroup.title'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('title', $model->title, ['class' => 'form-control']) !!}
            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('sequence') ? 'has-error' : ''}}">
        {!! Form::label('sequence', trans('app.stageGroup.sequence'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::number('sequence', $model->sequence, ['class' => 'form-control']) !!}
            {!! $errors->first('sequence', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::button(trans('app.btn.save'), ['type' => 'submit', 'class' => 'btn btn-md btn-primary']) !!}
            <a href="{{ url('/stage-groups') }}" class="btn btn-md btn-default">{!! trans('app.btn.cancel') !!}</a>
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <hr/>
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
                <th>{!! trans('app.btn.actions') !!}</th>
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
                    <td>
                        @role('admin')
                        <a href="{{ url('/stages/' . $stage->id . '/edit') }}" class="btn btn-primary btn-xs">{!! trans('app.btn.update') !!}</a>

                        {!! Form::model($stage, ['method' => 'delete', 'url' => ['/stages', $stage->id], 'class' =>'form-delete', 'style'=>'display:inline']) !!}
                        {!! Form::hidden('id', $stage->id) !!}
                        {!! Form::button(trans('app.btn.delete'), ['type' => 'submit', 'class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                        {!! Form::close() !!}
                        @endrole
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
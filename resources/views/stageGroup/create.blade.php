@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ trans('app.stageGroup.header.create') }}</h1>
    <hr/>

    {!! Form::open(['url' => '/stage-groups', 'class' => 'form-horizontal']) !!}

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
                {!! Form::button( trans('app.btn.save'), ['type' => 'submit', 'class' => 'btn btn-primary btn-md']) !!}
                <a href="{{ url('stage-groups', $model->id) }}" class="btn btn-md btn-default">{!! trans('app.btn.cancel') !!}</a>
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

</div>
@endsection
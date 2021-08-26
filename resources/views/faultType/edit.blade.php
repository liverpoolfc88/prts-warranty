@extends('layouts.app')

@section('content')
<div class="container">

    <h1>{{ trans('app.fault_type.header.edit') }}</h1>
    <hr/>

    {!! Form::model($model, [
        'method' => 'PATCH',
        'id' =>'form-vehicle-models',
        'url' => ['/fault_type', $model->id],
        'class' => 'form-horizontal'
    ]) !!}
        @include('faultType._form')

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::button(trans('app.btn.save'), ['type' => 'submit', 'class' => 'btn btn-md btn-primary']) !!}
            <a href="{{ url('fault_type', $model->id) }}" class="btn btn-md btn-default">{!! trans('app.btn.cancel') !!}</a>
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
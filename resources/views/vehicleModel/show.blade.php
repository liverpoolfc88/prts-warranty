@extends('layouts.app')

@section('content')
<div class="container">

    <h1>
        {{ $model->name }}
        <a href="{{ url('/vehicle-models/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">{!! trans('app.btn.update') !!}</a>
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <td>{{ $model->id }}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.vehicleModel.name') }} </th>
                    <td><a href="{{ url('vehicle-models', $model->id) }}">{{ $model->name }}</a></td>
                </tr>
                <tr>
                    <th>{{ trans('app.vehicleModel.responsibleEmail') }}</th>
                    <td>{{ $model->responsible_email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="{{ url('/vehicle-models') }}" class="btn btn-default btn-xs pull-right">{!! trans('app.btn.back') !!}</a>

</div>
@endsection
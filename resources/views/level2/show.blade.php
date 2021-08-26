@extends('layouts.app')

@section('content')
<div class="container">

    <h1>
        {{ $model->name }}
        <a href="{{ url('/level2/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">{!! trans('app.btn.update') !!}</a>
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <td>{{ $model->id }}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.level2.level_first_id') }} </th>
                    <td>{{ $model->level_first_id }}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.level2.name') }} </th>
                    <td><a href="{{ url('level2', $model->id) }}">{{ $model->name }}</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="{{ url('/level2') }}" class="btn btn-default btn-xs pull-right">{!! trans('app.btn.back') !!}</a>

</div>
@endsection
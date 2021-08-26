@extends('layouts.app')

@section('content')
<div class="container">

    <h1>
        {{ $model->name }}
        <a href="{{ url('/dealers/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">{!! trans('app.btn.update') !!}</a>
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <td>{{ $model->id }}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.dealer.name') }} </th>
                    <td><a href="{{ url('department', $model->id) }}">{{ $model->name }}</a></td>
                </tr>                
                <tr>
                    <th> {{ trans('app.dealer.address') }} </th>
                    <td> {{ $model->address }} </td>
                </tr>
                <tr>
                    <th> {{ trans('app.dealer.contact') }} </th>
                    <td> {{ $model->contact }} </td>
                </tr>

            </tbody>
        </table>
    </div>
    <a href="{{ url('/dealers') }}" class="btn btn-default btn-xs pull-right">{!! trans('app.btn.back') !!}</a>

</div>
@endsection
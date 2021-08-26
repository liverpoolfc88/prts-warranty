@extends('layouts.app')

@section('content')
<div class="container">

    <h1>
        {{ $model->name }}
        <a href="{{ url('/users/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">{!! trans('app.btn.update') !!}</a>
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <td>{{ $model->id }}</td>
                </tr>
                <tr>
                    <th> {{ trans('app.user.name') }} </th>
                    <td><a href="{{ url('users', $model->id) }}">{{ $model->name }}</a></td>
                </tr>
                <tr>
                    <th> {{ trans('app.user.email') }} </th>
                    <td> {{ $model->email }} </td>
                </tr>
                <tr>
                    <th> {{ trans('app.user.phone_number') }} </th>
                    <td> {{ $model->phone_number }} </td>
                </tr>
                <tr>
                    <th>{{ trans('app.problem.department_id') }}</th>
                    <td>
                        @foreach($model->departments as $department)
                            <span class="label label-info"> {{ $department->name }} </span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th> {{ trans('app.user.role') }} </th>
                    <td> {{ trans('app.user.role_'.$model->role) }} </td>
                </tr>
                @if($model->role == \App\User::ROLE_EMPLOYEE)
                    <tr>
                        <th> {{ trans('app.user.role_id') }} </th>
                        <td> {{ count($model->roles)> 0 ? $model->roles[0]->name : '' }} </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <a href="{{ url('/users') }}" class="btn btn-default btn-xs pull-right">{!! trans('app.btn.back') !!}</a>

</div>
@endsection
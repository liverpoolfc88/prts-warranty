@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ trans('app.dealer.header.create') }}</h1>
    <hr/>

    {!! Form::open(['url' => '/dealers', 'class' => 'form-horizontal']) !!}

        @include('dealer._form')

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {!! Form::button( trans('app.btn.save'), ['type' => 'submit', 'class' => 'btn btn-primary btn-md']) !!}
                <a href="{{ url('dealers', $model->id) }}" class="btn btn-md btn-default">{!! trans('app.btn.cancel') !!}</a>
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
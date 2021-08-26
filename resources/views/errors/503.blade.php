@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>503 Service Unavailable</h3>
                        <p>The server is currently unavailable (because it is overloaded or down for maintenance). Generally, this is a temporary state.</p>
                        <a href="{{ url('/') }}" class="btn btn-default btn-lg">{{ trans('app.home_page') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

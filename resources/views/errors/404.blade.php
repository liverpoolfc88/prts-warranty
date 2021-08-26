@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>404 Not Found</h3>
                        <p>The requested resource could not be found but may be available in the future. Subsequent requests by the client are permissible.</p>
                        <a href="{{ url('/') }}" class="btn btn-default btn-lg">{{ trans('app.home_page') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

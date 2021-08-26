@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>403 Forbidden</h3>
                        <p>The request was valid, but the server is refusing action. The user might not have the necessary permissions for a resource, or may need an account of some sort.</p>
                        <a href="{{ url('/') }}" class="btn btn-default btn-lg">{{ trans('app.home_page') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>401 Unauthorized</h3>
                        <p>Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided. The response must include a WWW-Authenticate header field containing a challenge applicable to the requested resource. See Basic access authentication and Digest access authentication.[33] 401 semantically means "unauthenticated",[34] i.e. the user does not have the necessary credentials.
                            Note: Some sites issue HTTP 401 when an IP address is banned from the website (usually the website domain) and that specific address is refused permission to access a website.</p>
                        <a href="{{ url('/') }}" class="btn btn-default btn-lg">{{ trans('app.home_page') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

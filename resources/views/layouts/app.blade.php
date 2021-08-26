<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PRTS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/plugins/bootstrap-switch-master/css/bootstrap-switch.min.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'PRPS') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if(isset($MainMenu))
                    {{--                        {!! $MainMenu->asUl(['class'=>'nav navbar-nav']) !!}--}}
                    <ul class="nav navbar-nav">
                        @include(config('laravel-menu.views.bootstrap-items'), array('items' => $MainMenu->roots()))
                    </ul>
                @endif

            <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">{{ trans('app.menu.login') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('changePassword') }}">{{ trans('app.menu.changePassword') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {!! trans('app.menu.logout') !!}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/plugins/jsrender.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.ru.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.uz-cyrl.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.uz-latn.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-switch-master/js/bootstrap-switch.min.js') }}"></script>
<script>
    //https://stackoverflow.com/questions/33757236/how-to-use-my-own-jquery-in-laravel-5
    jQuery(document).ready(function () {
        $('table[data-form="deleteForm"]').on('click', '.form-delete', function (e) {
            e.preventDefault();
            var $form = $(this);
            $("#modal_header").html($form.children('button:first').data('title'));
            $("#modal_content").html($form.children('button:first').data('message'));

            /*$("#modal_header").html($(e.relatedTarget).data('title'));
            $("#modal_content").html($(e.relatedTarget).data('message'));*/

            $('#confirm').modal({backdrop: 'static', keyboard: false}).on('click', '#delete-btn', function () {
                $form.submit();
            });
        });

        $('.datepicker').datepicker({
            language: 'ru',
            format: 'yyyy-mm-dd'
        });

        $(".bootstrap-switch").bootstrapSwitch({
            onText: '{{ trans('app.problemActions.accepted_1') }}',
            offText: '{{ trans('app.problemActions.accepted_0') }}',
            offColor: 'danger',
            onColor: 'success',
            size: 'large'
        });

        @yield('scripts');
    });
</script>

@include('modal')

</body>
</html>

<!doctype html>
<html @stack('html_attributes')
      {!! admin()->html_attributes() !!}
      data-layout="vertical"
      data-topbar="light"
      data-sidebar="dark"
      data-sidebar-size="lg"
      data-sidebar-image="none"
      data-preloader="disable"
      data-theme="default"
      data-theme-colors="default"
>
<head>
    @stack('html_meta')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{admin()->title() ?? admin()->name()}}</title>
    <style nonce="{{admin()->csp()}}">
        body, html {
            margin: 0;
            padding: 0;
        }
    </style>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{admin()->asset('images/favicon.ico')}}">
    <script src="{{admin()->asset('js/layout.js')}}"></script>
    <link href="{{admin()->asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin()->asset('css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin()->asset('css/app.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin()->asset('css/custom.min.css')}}" rel="stylesheet" type="text/css"/>
    @stack('styles')
    <style nonce="{{admin()->csp()}}">
        {!! $_this->styles() !!}
    </style>
</head>
<body @stack('body_attributes')>
@yield('body')
<script src="{{admin()->asset('libs/jquery/jquery.min.js')}}"></script>
<script src="{{admin()->asset('libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{admin()->asset('libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{admin()->asset('libs/node-waves/waves.min.js')}}"></script>
<script src="{{admin()->asset('libs/feather-icons/feather.min.js')}}"></script>
<script src="{{admin()->asset('libs/choices.js/public/assets/scripts/choices.min.js ')}}"></script>
<script src="{{admin()->asset('libs/flatpickr/flatpickr.min.js')}}"></script>
<!-- App js -->
<script src="{{admin()->asset('js/app.js')}}"></script>
<script src="{{admin()->asset('js/admin.js')}}"></script>
@stack('scripts')
<script nonce="{{admin()->csp()}}">
    {!! $_this->scripts() !!}
</script>
</body>
</html>

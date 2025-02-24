<!doctype html>
<html @stack('html_attributes') {!! admin()->getAttributes()->merge([
      'data-layout'=> "vertical",
      'data-topbar'=> "light",
      'data-sidebar'=> "dark",
      'data-sidebar-size'=> "lg",
      'data-sidebar-image'=> "none",
      'data-preloader'=> "disable",
      'data-theme'=> "default",
      'data-theme-colors'=> "default",
    ]) !!}>
<head>
    @stack('html_meta')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csp-nonce" content="{{ admin()->csp() }}">
    <title>{{admin()->title() ?? admin()->name()}}</title>
    <link rel="shortcut icon" href="{{admin()->favicon() ?? admin()->asset('images/favicon.ico')}}">
    @foreach(admin()->css() as $css)
        <link href="{{$css}}" rel="stylesheet" type="text/css"/>
    @endforeach
    @stack('styles')
    <style nonce="{{admin()->csp()}}">
        {!! $_this->styles() !!}
    </style>
</head>
<body @stack('body_attributes')>
@yield('body')
@foreach(admin()->js() as $js)
    <script src="{{$js}}"></script>
@endforeach
@stack('scripts')
<script nonce="{{admin()->csp()}}">
    {!! $_this->scripts() !!}
</script>
@include('admin::partials.toasts')
</body>
</html>

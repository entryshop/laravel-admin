<!doctype html>
<html @stack('html_attributes')>
<head>
    @stack('html_meta')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <style nonce="{{csp_nonce()}}">
        body, html {
            margin: 0;
            padding: 0;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
    <style nonce="{{admin()->csp()}}">
        {!! $_this->styles() !!}
    </style>
</head>
<body @stack('body_attributes')>
@yield('body')
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="{{asset('vendor/admin/js/admin.js')}}"></script>
@stack('scripts')
<script nonce="{{admin()->csp()}}">
    {!! $_this->scripts() !!}
</script>
</body>
</html>

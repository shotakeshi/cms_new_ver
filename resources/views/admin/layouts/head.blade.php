<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>@yield('title') | {{ env('TEAM_NAME') }}</title>
    <meta content="Administrator | {{ env('TEAM_NAME') }}" name="description" />
    <meta content="{{ env('AUTHOR') }}" name="author" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('administrator/assets/images/logo-sm.png') }}">
    @stack('styles')
    <!-- Sweet Alert -->
    <link href="{{ asset('administrator/phoenix/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('administrator/phoenix/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
    <!-- App css -->
    <link href="{{ asset('administrator/phoenix/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('administrator/phoenix/assets/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('administrator/phoenix/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('administrator/phoenix/assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('administrator/phoenix/assets/css/app.min.css') }}?v={{ time() }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('administrator/phoenix/assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('administrator/phoenix/assets/css/custom.css') }}?v={{ time() }}" rel="stylesheet" type="text/css">
    <script>
        var translations = @json(__('site'));
    </script>
</head>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ __('site.login.title') }}</title>
    <meta content="{{ __('site.login.title') }}" name="description" />
    <meta content="Hà Anh Hiếu" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('administrator/assets/images/favicon.ico') }}">
    <!-- App css -->
    <link href="{{ asset('administrator/phoenix/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('administrator/phoenix/assets/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('administrator/phoenix/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('administrator/phoenix/assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('administrator/phoenix/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .auth-bg{
            background: url("../administrator/assets/images/bg-login.png") center center;
        }
    </style>
</head>
<body class="bg-card">
<div class="container-fluid">
    <div class="row vh-100">
        <div class="col-lg-3 pr-0">
            <div class="auth-page">
                <div class="card mb-0 shadow-none h-100">
                    <div class="card-body">
                        <div class="mb-5 text-center">
                            <a href="javascript:void(0)" class="logo logo-admin">
                                <span><img src="{{ asset('administrator/assets/images/logo-light.png') }}" height="200" alt="logo" class="my-3"></span>
                            </a>
                        </div>
                        <form class="form-horizontal auth-form my-4" action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('site.login.email') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="email" id="email"
                                           value="{{ old('email') }}" placeholder="{{ __('site.login.email') }}">
                                </div>
                            </div><!--end form-group-->
                            <div class="form-group">
                                <label for="password">{{ __('site.login.password') }}</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="{{ __('site.login.password') }}">
                                </div>
                                <div class="custom-control custom-switch switch-success">
                                    <input type="checkbox" name="remember" class="custom-control-input"
                                           id="customSwitchSuccess">
                                    <label class="custom-control-label text-muted"
                                           for="customSwitchSuccess">{{ __('site.login.remember') }}</label>
                                </div>
                            </div><!--end form-group-->
                            @if($errors->any())
                                <ul class="pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="form-group mb-0 row">
                                <div class="col-12 mt-2">
                                    <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" type="submit">
                                        {{ __('site.button.login') }} <i class="fas fa-sign-in-alt ml-1"></i>
                                    </button>
                                </div><!--end col-->
                            </div> <!--end form-group-->
                        </form><!--end form-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 p-0 h-100vh d-flex justify-content-center auth-bg">
            <div class="accountbg d-flex align-items-center">
                <div class="account-title text-center text-white">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery  -->
<script src="{{ asset('administrator/phoenix/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/metismenu.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/waves.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/feather.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/jquery.slimscroll.min.js') }}"></script>
<script>
    feather.replace()
</script>
</body>
</html>
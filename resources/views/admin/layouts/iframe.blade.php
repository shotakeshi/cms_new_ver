<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.layouts.head')
<body>
    @yield('content')
    @include('admin.layouts.script')
</body>
</html>

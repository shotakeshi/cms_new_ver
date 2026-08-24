<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.layouts.head')
<body>
    <!-- Main Wrapper -->
    @include('admin.layouts.partials.leftbar-tab-menu')
    @include('admin.layouts.partials.topbar')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="page-content-tab">
            @yield('content')
            <!-- END ROW -->
            @include('admin.layouts.partials.footer')
        </div>
        <!-- end container-fluid -->
    </div>
    <div id="ajax-overlay" class="overlay">
        <div class="loader"></div>
    </div>
    <!-- /Main Wrapper -->
    @include('admin.layouts.partials.preloader')
    @include('admin.layouts.script')
</body>
</html>

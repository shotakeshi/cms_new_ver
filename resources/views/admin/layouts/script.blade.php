<!-- jQuery  -->
<script src="{{ asset('administrator/phoenix/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/metismenu.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/waves.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/feather.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/common.js') }}"></script>
<!-- Sweet-Alert  -->
<script src="{{ asset('administrator/phoenix/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/pages/jquery.sweet-alert.init.js') }}"></script>
<script src="{{ asset('administrator/phoenix/assets/js/delete-confirm.js') }}"></script>
<!-- Plugins js -->
@stack('scripts')
<!-- App js -->
<script src="{{ asset('administrator/phoenix/assets/js/app.js') }}?v={{ time() }}"></script>
@include('ckfinder::setup')
<script>
    window.trans = {
        delete: "{{ __('site.button.confirm_delete') }}",
        cancel: "{{ __('site.button.cancel') }}",
        delete_warning: "{{ __('common.messages.delete_warning') }}",
        delete_confirm: "{{ __('common.messages.delete_confirm') }}"
    };
</script>
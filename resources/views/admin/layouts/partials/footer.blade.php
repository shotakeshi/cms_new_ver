<!-- Footer -->
<footer class="footer ">
    &copy; {{ now()->year }} - {{ now()->year+1 }}
    <span class="text-muted d-none d-sm-inline-block float-right">{{ __('site.footer.crafted_with') }} <i class="mdi mdi-heart text-danger"></i> {{ __('site.footer.by') }} {{ env('TEAM_NAME') }}</span>
</footer><!--end footer-->
<!-- End Footer -->
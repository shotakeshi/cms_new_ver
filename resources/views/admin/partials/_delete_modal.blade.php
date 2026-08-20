<!-- /Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('site.notification.title_delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h3 class="modal-title mt-0" id="exampleModalLabel">{{ __('site.notification.confirm_delete') }}</h3>
                <h5>{{ __('site.notification.warning_delete') }}</h5>
                <hr>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <form id="deleteForm" class="mr-3" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="dripicons-thumbs-up"></i> {{ __('site.button.delete') }}
                        </button>
                    </form>
                    <button type="button"
                            class="btn btn-gradient-danger"
                            data-dismiss="modal">
                        <i class="ti-close"></i> {{ __('site.button.cancel') }}
                    </button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

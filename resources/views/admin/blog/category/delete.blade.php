<a data-toggle="modal" href=".delete_modal_{{$page->id}}" class="btn btn-sm btn-gradient-danger" style="width: 32px">
    <i class="dripicons-trash"></i>
</a>
<!-- Delete Modal -->
<div class="modal fade delete_modal_{{$page->id}}" id="delete_modal" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" >
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-content p-2 text-center">
                    <h2 class="mb-2">{{ __('site.notification.confirm_delete') }}</h2>
                    <p class="font-bold font-15">{{ __('site.notification.warning_delete') }}</p>
                    <div class="btn btn-sm">
                        <form action="{{ route('pages.destroy', $page) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-gradient-primary"><i class="dripicons-thumbs-up"></i> {{ __('site.button.delete') }}</button>
                        </form>
                    </div>
                    <button type="button" class="btn btn-gradient-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('site.button.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->
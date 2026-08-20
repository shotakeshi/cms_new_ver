<button type="button" class="btn btn-sm btn-gradient-primary" data-toggle="modal" data-target=".bs-create-position-{{ $department->id }}">
    <i class="fa fa-plus"></i> {{ __('site.department.create_position') }}
</button>
<div class="modal fade bs-create-position-{{ $department->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('site.department.create_position') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <form class="" action="{{ route('department.store-position', $department->id) }}" method="POST">
                    @csrf
                    <div id="name" class="form-group">
                        <label>{{ __('site.department.name') }}</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="{{ __('site.department.name') }}"/>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-gradient-primary">
                                <i class="fa fa-save"></i> {{ __('site.button.create') }}
                            </button>
                            <button data-dismiss="modal" aria-label="Close" type="reset" class="btn btn-gradient-danger m-l-5">
                                <i class="ti-close"></i> {{ __('site.button.cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
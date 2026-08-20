<form id="form-change-password" action="{{ route('admin.reset-password',$admin->id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-3">
        </div>
        <div class="col-6">
            <div id="password" class="form-group">
                <label for="password" class="col-form-label">{{ __('site.admin.password') }} <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control"
                       placeholder="{{ __('site.admin.password') }}">
                <div id="messages-password" class="form-control-feedback text-danger"></div>
            </div>
            <div id="password-confirmation" class="form-group">
                <label for="password-confirmation"
                       class="col-form-label">{{ __('site.admin.password_confirmation') }} <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation"
                       class="form-control" placeholder="{{ __('site.admin.password_confirmation') }}">
                <div id="messages-password-confirmation" class="form-control-feedback text-danger"></div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <button type="button" id="btn-change-password" class="btn btn-lg btn-gradient-primary waves-effect waves-light active w-100"><i class="far fa-save"></i> {{ __('site.button.update') }}</button>
                </div>
                <div class="col-6">
                    <a href="{{ route('admins.index') }}" class="btn btn-lg btn-gradient-danger w-100">
                        <i class="fas fa-arrow-left"></i> {{ __('site.button.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
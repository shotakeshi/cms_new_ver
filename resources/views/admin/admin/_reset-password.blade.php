<form id="form-change-password" action="{{ route('admin.reset-password', $admin) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-6 mx-auto">
            <x-admin::forms.input
                    name="password"
                    type="password"
                    label="{{ __('site.admin.password') }}"
                    placeholder="{{ __('site.admin.password') }}"
                    required
            />
            <x-admin::forms.input
                    name="password_confirmation"
                    type="password"
                    label="{{ __('site.admin.password_confirmation') }}"
                    placeholder="{{ __('site.admin.password_confirmation') }}"
                    required
            />
            <div class="text-right">
                <a href="{{ route('admins.index') }}" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('site.button.back') }}
                </a>
                <button type="submit" id="btn-change-password" class="btn btn-sm btn-outline-primary">
                    <i class="far fa-save"></i>
                    {{ __('site.button.update') }}
                </button>
            </div>
        </div>
    </div>
</form>
@push('scripts')
    <script>
        $(function () {
            const $form = $('#form-change-password');
            const $button = $('#btn-change-password');

            $form.on('submit', function (e) {
                e.preventDefault();

                clearErrors();

                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method') || 'POST',
                    data: $form.serialize(),

                    beforeSend: function () {
                        $button.prop('disabled', true);
                    },

                    success: function () {
                        toastr.success(
                            '{{ __('site.notification.update_success') }}',
                            'Success'
                        );

                        $form[0].reset();
                    },

                    error: function (xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON?.errors ?? {};

                            Object.keys(errors).forEach(function (field) {
                                showError(
                                    field,
                                    errors[field]?.[0]
                                );
                            });

                            return;
                        }

                        toastr.error(
                            xhr.responseJSON?.message ??
                            '{{ __('site.notification.error') }}',
                            'Error'
                        );
                    },

                    complete: function () {
                        $button.prop('disabled', false);
                    }
                });
            });

            /**
             * Show validation error
             */
            function showError(field, message) {
                if (!message) {
                    return;
                }

                const $input = $('#' + field);
                const $message = $('#messages-' + field);

                if ($input.length) {
                    $input.addClass('is-invalid');
                }

                if ($message.length) {
                    $message
                        .text(message)
                        .show();
                }
            }

            /**
             * Clear validation errors
             */
            function clearErrors() {
                $form.find('input').removeClass('is-invalid');

                $form.find('[id^="messages-"]')
                    .empty()
                    .hide();
            }
        });
    </script>
@endpush
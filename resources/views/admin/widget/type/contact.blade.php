<div class="row">
    <div class="col-lg-12">
        <ul class="nav mb-3" id="pills-tab" role="tablist">
            @foreach($globalLanguages as $key => $language)
                <li class="nav-item mr-3 {{ $key === 0 ? 'show active' : '' }}">
                    <a class="btn btn-outline-danger {{ $key === 0 ? 'active' : '' }}" id="widget_tab" data-toggle="pill" href="#{{ $language->slug }}">
                        {{ $language->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-lg-12">
        <div class="tab-content detail-list border p-3" id="pills-tabContent">
            @foreach($globalLanguages as $key => $language)
                <div class="tab-pane fade mt-0 {{ $key === 0 ? 'show active' : '' }}" id="{{ $language->slug }}">
                    <div class="repeater-custom-show-hide repeater">
                        <div data-repeater-list="{{ $language->slug }}">
                            <div data-repeater-item="">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <x-admin::forms.input
                                                name="{{ $language->slug }}[name][]"
                                                label="{{ __('site.widget.name') }}"
                                                placeholder="{{ __('site.widget.name') }}"
                                        />
                                    </div>
                                    <div class="col-lg-7">
                                        <x-admin::forms.input
                                                name="{{ $language->slug }}[value][]"
                                                label="{{ __('site.widget.value') }}"
                                                placeholder="{{ __('site.widget.value') }}"
                                        />
                                    </div>
                                    <div class="col-lg-1">
                                        <span data-repeater-delete="" class="btn btn-gradient-danger w-100">
                                            <span class="far fa-trash-alt mr-1"></span> {{ __('site.widget.btn_delete') }}
                                        </span>
                                        <button type="button"
                                                class="btn btn-gradient-secondary btn-move-up w-100 mt-3"
                                                title="Di chuyển lên">
                                            <i class="fas fa-arrow-up"></i> Up
                                        </button>
                                        <button type="button"
                                                class="btn btn-gradient-primary btn-move-down w-100 mt-3"
                                                title="Di chuyển xuống">
                                            <i class="fas fa-arrow-down"></i> Down
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-12 text-right">
                                <span data-repeater-create="" class="btn btn-outline-secondary btn-md">
                                    <span class="fa fa-plus"></span> {{ __('site.widget.add_row') }}
                                </span>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div><!--end general detail-->
            @endforeach
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('administrator/assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('.repeater-default').repeater();
            $('.repeater-custom-show-hide').repeater({
                show: function () {
                    const $this = $(this);

                    $this.slideDown(function () {
                        // Dọn wrapper được clone từ Dropify
                        $this.find('.dropify-wrapper').each(function () {
                            const $wrapper = $(this);
                            const $input = $wrapper.find('input.dropify');

                            if ($input.length) {
                                $wrapper.before($input);
                            }

                            $wrapper.remove();
                        });

                        // Reset input file vừa clone
                        $this.find('input.dropify').each(function () {
                            $(this)
                                .removeClass('dropify-initialized')
                                .removeAttr('data-default-file');
                        });

                        // Hiển thị item rồi khởi tạo lại
                        $this.slideDown(function () {
                            $this.find('input.dropify').dropify();
                        });
                    });
                },
                hide: function (remove) {
                    if (confirm('Are you sure you want to remove this item?')) {
                        $(this).slideUp(remove);
                    }
                }
            });

            $(document).on('click', '.btn-move-up', function () {
                const $item = $(this).closest('[data-repeater-item]');
                const $prev = $item.prev('[data-repeater-item]');

                if ($prev.length) {
                    $item.insertBefore($prev);
                }

                updateMoveButtons();
            });

            $(document).on('click', '.btn-move-down', function () {
                const $item = $(this).closest('[data-repeater-item]');
                const $next = $item.next('[data-repeater-item]');

                if ($next.length) {
                    $item.insertAfter($next);
                }

                updateMoveButtons();
            });

            function updateMoveButtons() {
                $('.repeater').each(function () {
                    const $items = $(this).find('[data-repeater-list]')
                        .first()
                        .children('[data-repeater-item]');

                    $items.each(function (index) {
                        const $item = $(this);

                        $item.find('.btn-move-up, .btn-move-down')
                            .prop('disabled', false);

                        // Item đầu tiên: khóa nút lên
                        if (index === 0) {
                            $item.find('.btn-move-up').prop('disabled', true);
                        }

                        // Item cuối cùng: khóa nút xuống
                        if (index === $items.length - 1) {
                            $item.find('.btn-move-down').prop('disabled', true);
                        }
                    });
                });
            }

            $(document).on(
                'click',
                '[data-repeater-create], [data-repeater-delete]',
                function () {
                    setTimeout(updateMoveButtons, 100);
                }
            );

            $(document).ready(function () {
                updateMoveButtons();
            });
        });
    </script>
@endpush
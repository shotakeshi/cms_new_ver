@extends('admin.layouts.app')
@section('title')
    {{ __('site.landing-pages.title') }}
@endsection
@push('styles')
    <link href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('administrator/phoenix/plugins/timepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}?v=1" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <style>
        /* Widget item */
        .widget-item {
            padding: 14px 16px;
            margin-bottom: 10px;
            background: #fff;
            border: 1px solid #e9edf3;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .widget-row-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            cursor: pointer;
        }

        .widget-item:hover {
            border-color: #9bbcff;
            background: #f8faff;
        }

        .widget-checkbox {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
        }

        .custom-checkbox {
            width: 21px;
            height: 21px;
            flex-shrink: 0;
            margin-right: 14px;
            border: 2px solid #cbd2dc;
            border-radius: 6px;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .custom-checkbox::after {
            content: "";
            width: 5px;
            height: 10px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) scale(0);
        }

        .widget-checkbox:checked + .custom-checkbox {
            background: #377dff;
            border-color: #377dff;
        }

        .widget-checkbox:checked + .custom-checkbox::after {
            transform: rotate(45deg) scale(1);
        }

        .widget-item:has(.widget-checkbox:checked) {
            border-color: #377dff;
            background: #f3f7ff;
        }

        .widget-type {
            color: #377dff;
            background: #edf4ff;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
        }

        .transaction-history li{
            padding: 15px !important;
        }

        .transaction-history li:last-of-type{
            border: 1px solid #e9edf3 !important;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.landing-pages.create_title')"
        />
        <form id="page" action="{{ route('landing-pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.page.detail') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.input
                                name="name"
                                label="{{ __('site.page.name') }}"
                                placeholder="{{ __('site.page.name') }}"
                                required
                                onkeyup="generateSlug(this)"
                            />
                            <x-admin::forms.input
                                name="slug"
                                label="{{ __('site.page.slug') }}"
                                placeholder="{{ __('site.page.slug') }}"
                                required
                            />
                            <x-admin::forms.textarea
                                    name="description"
                                    label="{{ __('site.page.description') }}"
                                    placeholder="{{ __('site.page.description') }}"
                                    rows="5"
                            />
                            <x-admin::forms.textarea
                                    name="content"
                                    label="{{ __('site.page.content') }}"
                                    placeholder="{{ __('site.page.content') }}"
                                    rows="5"
                                    required
                                    ckeditor
                            />
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.landing-pages.more') }}
                        </div>
                        <div class="card-body">
                            <div class="repeater-custom-show-hide repeater">
                                <div data-repeater-list="more">
                                    <div data-repeater-item="">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <x-admin::forms.input
                                                        name="more[name][]"
                                                        label="{{ __('site.landing-pages.more_name') }}"
                                                        placeholder="{{ __('site.landing-pages.more_name') }}"
                                                />
                                                <x-admin::forms.textarea
                                                        name="more[content][]"
                                                        label="{{ __('site.landing-pages.more_content') }}"
                                                        placeholder="{{ __('site.landing-pages.more_content') }}"
                                                        rows="5"
                                                        ckeditor
                                                />
                                            </div>
                                            <div class="col-lg-2">
                                                <span data-repeater-delete="" class="btn btn-gradient-danger w-100">
                                                    <span class="far fa-trash-alt mr-1"></span> {{ __('site.widget.btn_delete') }}
                                                </span>
                                                <button type="button"
                                                        class="btn btn-gradient-secondary btn-move-up w-100 mt-3"
                                                        title="{{ __('site.widget.move_up') }}">
                                                    <i class="fas fa-arrow-up"></i> {{ __('site.widget.up') }}
                                                </button>
                                                <button type="button"
                                                        class="btn btn-gradient-primary btn-move-down w-100 mt-3"
                                                        title="{{ __('site.widget.move_down') }}">
                                                    <i class="fas fa-arrow-down"></i> {{ __('site.widget.down') }}
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
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <strong class="italic">{{ __('site.language_default') . ': ' . $currentLanguage->name }}</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <x-admin::forms.single_file
                                            name="file"
                                            label="{{ __('site.page.avatar') }}"
                                            accept="image/jpeg,image/png,image/webp"
                                    />
                                </div>
                                <div class="col-6">
                                    <x-admin::forms.radio-enums
                                            name="status"
                                            label="{{ __('site.admin.status') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                            :selected="\App\Enums\DefaultStatus::ACTIVE->value"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.landing-pages.widgets') }}
                        </div>
                        <div class="card-body">
                            <ul class="list-unsyled m-0 pl-0 transaction-history">
                                @forelse($widgets as $widget)
                                    <li class="widget-item align-items-center d-flex justify-content-between">
                                        <label class="widget-row-label mb-0">
                                            <div class="media align-items-center">
                                                <input
                                                        type="checkbox"
                                                        name="more[widgets][{{ $widget->id }}]"
                                                        value="{{ $widget->id }}"
                                                        class="widget-checkbox"
                                                >
                                                <span class="custom-checkbox"></span>

                                                <div class="media-body align-self-center">
                                                    <div class="transaction-data">
                                                        <h3 class="m-0">{{ $widget->name }}</h3>
                                                        <p class="text-muted mb-0">{{ $widget->slug }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="widget-type">{{ $widget->type }}</span>
                                        </label>
                                    </li>
                                @empty
                                    <p>No Widget</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.page.seo') }} | {{ __('site.page.seo_config') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.input
                                    name="meta_title"
                                    label="{{ __('site.page.meta_title') }}"
                                    placeholder="{{ __('site.page.meta_title') }}"
                                    maxlength="60"
                            />
                            <x-admin::forms.textarea
                                    name="meta_description"
                                    label="{{ __('site.page.meta_description') }}"
                                    placeholder="{{ __('site.page.meta_description') }}"
                                    rows="5"
                                    maxlength="150"
                            />
                            <x-admin::forms.tagsinput
                                    name="meta_keywords"
                                    label="{{ __('site.page.meta_keywords') }}"
                                    placeholder="{{ __('site.page.meta_keywords') }}"
                            />
                            <x-admin::forms.actions
                                    :back-url="route('landing-pages.index')"
                                    show-reset
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('administrator/assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script>
        function generateSlug(input){
            const slug = document.getElementById("slug");
            slug.value = createSlug(input.value);
        }

        function createSlug(string) {
            return string
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/đ/g, "d")
                .replace(/Đ/g, "D")
                .replace(/[^a-zA-Z0-9\s-]/g, "")
                .trim()
                .replace(/\s+/g, "-")
                .replace(/-+/g, "-")
                .toLowerCase();
        }

        $('input#meta_title, textarea#meta_description').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger",
            separator: ' {{ __('seo.separator') }} ',
            preText: '{{ __('seo.pre_text') }} ',
            postText: ' {{ __('seo.post_text') }}',
            validate: true
        });

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

                        $this.find('textarea.ckeditor').each(function () {
                            const textarea = this;
                            textarea.id = 'ckeditor_' + Date.now() + '_' +
                                Math.random().toString(36).substring(2, 8);
                            // Khởi tạo CKEditor nếu chưa tồn tại
                            if (!CKEDITOR.instances[textarea.id]) {
                                CKEDITOR.replace(textarea, {
                                    removePlugins: 'exportpdf'
                                });
                            }
                        });
                    });
                },
                hide: function (remove) {
                    if (confirm(@json(__('site.widget.confirm_remove_item')))) {
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

            $('.dropify').dropify().on('dropify.afterClear', function(event, element) {
                const name = this.name;
                $(`input[name="${name}"]`).val(null);
            });
        });
    </script>
@endpush
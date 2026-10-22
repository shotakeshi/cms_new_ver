@extends('admin.layouts.app')
@section('title')
    {{ __('site.page.title') }}
@endsection
@push('styles')
    <link href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('administrator/phoenix/plugins/timepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}?v=1" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.page.create_title')"
        />
        <form id="page" action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-7">
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
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <strong class="italic">{{ __('site.language_default') . ': ' . $currentLanguage->name }}</strong>
                        </div>
                        <div class="card-body">
                            <x-admin::forms.single_file
                                    name="file"
                                    label="{{ __('site.page.avatar') }}"
                                    accept="image/jpeg,image/png,image/webp"
                            />
                            <x-admin::forms.tagsinput
                                    name="tags"
                                    label="{{ __('site.tags') }}"
                                    placeholder="{{ __('site.tags') }}"
                            />
                            <x-admin::forms.datetime
                                    name="published_at"
                                    label="{{ __('site.page.published_at') }}"
                                    placeholder="dd/mm/yyyy - hh:mm"
                            />
                            <div class="row">
                                <div class="col-6">
                                    <x-admin::forms.radio-enums
                                            name="status"
                                            label="{{ __('site.admin.status') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                            :selected="\App\Enums\DefaultStatus::ACTIVE->value"
                                    />
                                </div>
                                <div class="col-6">
                                    <x-admin::forms.radio-enums
                                            name="status_comment"
                                            label="{{ __('site.page.status_comment') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                    />
                                </div>
                            </div>
                            <x-admin::forms.actions
                                    :back-url="route('pages.index')"
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

        $('#published_at').bootstrapMaterialDatePicker({
            format : 'DD/MM/Y - HH:mm',
            minDate: new Date()
        });
    </script>
@endpush
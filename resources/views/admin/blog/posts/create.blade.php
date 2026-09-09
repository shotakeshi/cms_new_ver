@extends('admin.layouts.app')
@section('title')
    {{ __('site.blog.posts.title') }}
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
                :name="__('site.blog.posts.title')"
        />
        <form id="page" action="{{ route('blog-posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.blog.posts.detail') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.input
                                    name="name"
                                    label="{{ __('site.blog.posts.name') }}"
                                    placeholder="{{ __('site.blog.posts.name') }}"
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
                                    name="excerpt"
                                    label="{{ __('site.blog.posts.excerpt') }}"
                                    placeholder="{{ __('site.blog.posts.excerpt') }}"
                                    rows="5"
                                    required
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
                <div class="col-lg-4">
                    <div class="alert icon-custom-alert alert-outline-primary alert-primary-shadow" role="alert">
                        <i class="fas fa-exclamation alert-icon font-18"></i>
                        <div class="alert-text">
                            {{ __('site.language_default') . ': ' . $currentLanguage->name }}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.blog.posts.categories') }}
                        </div>
                        <div class="card-body overflow-auto" style="max-height: 250px;">
                            <x-admin::forms.checkbox-has-child
                                    name="blog_category_id"
                                    :options="$blogCategories"
                                    :contents="$blogCategoryContents"
                                    :locale="$refLang ?? $appLocale"
                                    :selected="old('blog_category_id')"
                            />
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <strong class="italic">{{ __('site.language_default') . ': ' . $currentLanguage->name }}</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-admin::forms.single_file
                                            name="file"
                                            label="{{ __('site.blog.posts.future_image') }}"
                                            accept="image/jpeg,image/png,image/webp"
                                    />
                                </div>
                                <div class="col-lg-6">
                                    <x-admin::forms.input
                                            name="post_password"
                                            type="text"
                                            label="{{ __('site.blog.posts.post_password') }}"
                                            placeholder="{{ __('site.blog.posts.post_password') }}"
                                    />
                                    <x-admin::forms.radio-enums
                                            name="status_comment"
                                            label="{{ __('site.page.status_comment') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                    />
                                </div>
                            </div>
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
                            <x-admin::forms.actions
                                    :back-url="route('blog-posts.index')"
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
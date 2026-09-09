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
                :name="__('site.page.update_title')"
        />
        <form id="page" action="{{ route('blog-posts.update', $blogPost) }}?ref_lang={{ $refLang }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.blog.posts.detail') }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="language_code" readonly value="{{ $refLang }}">
                            <x-admin::forms.input
                                    name="name"
                                    label="{{ __('site.blog.posts.name') }}"
                                    placeholder="{{ __('site.blog.posts.name') }}"
                                    :value="$blogPostContent?->name"
                                    required
                                    onkeyup="generateSlug(this)"
                            />
                            <x-admin::forms.input
                                    name="slug"
                                    label="{{ __('site.page.slug') }}"
                                    placeholder="{{ __('site.page.slug') }}"
                                    :value="$blogPostContent?->slug"
                                    required
                            />
                            <x-admin::forms.textarea
                                    name="excerpt"
                                    label="{{ __('site.blog.posts.excerpt') }}"
                                    placeholder="{{ __('site.blog.posts.excerpt') }}"
                                    :value="$blogPostContent?->excerpt"
                                    rows="5"
                                    required
                            />
                            <x-admin::forms.textarea
                                    name="content"
                                    label="{{ __('site.page.content') }}"
                                    placeholder="{{ __('site.page.content') }}"
                                    rows="5"
                                    :value="$blogPostContent?->content"
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
                                    :value="$blogPostContent?->meta_title"
                                    maxlength="60"
                            />
                            <x-admin::forms.textarea
                                    name="meta_description"
                                    label="{{ __('site.page.meta_description') }}"
                                    placeholder="{{ __('site.page.meta_description') }}"
                                    rows="5"
                                    maxlength="150"
                                    :value="$blogPostContent?->meta_description"
                            />
                            <x-admin::forms.tagsinput
                                    name="meta_keywords"
                                    label="{{ __('site.page.meta_keywords') }}"
                                    placeholder="{{ __('site.page.meta_keywords') }}"
                                    :value="$blogPostContent?->meta_keywords"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="alert icon-custom-alert alert-outline-primary alert-primary-shadow" role="alert">
                        <i class="fas fa-exclamation alert-icon font-18"></i>
                        <div class="alert-text">
                            {!!  __('site.page.note_update', ['locale' => $languageVersionName]) !!}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.page.another_lang') }}
                        </div>
                        <div class="card-body">
                            @foreach($globalLanguages as $language)
                                @if($language->slug != $refLang)
                                    <div>
                                        <a href="{{ route('blog-posts.edit', $blogPost) }}?ref_lang={{ $language->slug }}">
                                            <img alt="{{ $language->name }}" style="max-width: 20px" src="{{ asset('flags/'.$language->slug.'.png') }}">
                                            <span>{{ $language->name }}</span>
                                            <i class="font-16 far fa-edit text-primary pt-2"></i>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
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
                                    :selected="$blogPost?->categories()->pluck('blog_categories.id')->all() ?? []"
                            />
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.blog.posts.status_change') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.select
                                    name="status"
                                    :options="\App\Enums\BlogPostStatus::options()"
                                    selected="{{ $blogPost->status }}"
                            />
                            <div id="published-at-wrapper">
                                <x-admin::forms.datetime
                                        name="published_at"
                                        label="{{ __('site.page.published_at') }}"
                                        placeholder="dd/mm/yyyy - hh:mm"
                                        :value="$blogPost->published_at"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.page.detail') }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-admin::forms.single_file
                                            name="file"
                                            label="{{ __('site.blog.posts.future_image') }}"
                                            accept="image/jpeg,image/png,image/webp"
                                            :default-file="$blogPostContent?->image
                                                ? asset('storage/' . $blogPostContent->image)
                                                : null"
                                    />
                                    <input type="hidden" name="remove_image" id="remove_image" value="0" >
                                </div>
                                <div class="col-lg-6">
                                    <x-admin::forms.input
                                            name="post_password"
                                            type="text"
                                            label="{{ __('site.blog.posts.post_password') }}"
                                            placeholder="{{ __('site.blog.posts.post_password') }}"
                                            value="{{ old('post_password') }}"
                                    />
                                    @if ($blogPost->post_password)
                                        <div class="checkbox checkbox-primary">
                                            <input id="remove_post_password" type="checkbox" name="remove_post_password">
                                            <label for="remove_post_password">
                                                {{ __('site.blog.posts.remove_post_password') }}
                                            </label>
                                        </div>
                                    @endif
                                    <x-admin::forms.radio-enums
                                            name="status_comment"
                                            label="{{ __('site.page.status_comment') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                            :selected="$blogPost->status_comment"
                                    />
                                </div>
                            </div>
                            <x-admin::forms.tagsinput
                                    name="tags"
                                    label="{{ __('site.tags') }}"
                                    placeholder="{{ __('site.tags') }}"
                                    :value="$tagNames ?? ''"
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
        $('.dropify').dropify().on('dropify.afterClear', function(event, element) {
            document.getElementById('remove_image').value = 1;
        });

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

        const $status = $('#status');
        const $publishedAtWrapper = $('#published-at-wrapper');
        const $publishedAt = $('#published_at');

        function togglePublishedAt() {
            const status = $status.val();

            switch (status) {
                case 'schedule':
                    $publishedAtWrapper.removeClass('d-none');
                    $publishedAt.prop('disabled', false);
                    $publishedAt.prop('required', true);
                    break;

                case 'published':
                    $publishedAtWrapper.removeClass('d-none');
                    $publishedAt.prop('disabled', true);
                    $publishedAt.prop('required', false);
                    break;

                case 'draft':
                case 'private':
                default:
                    $publishedAtWrapper.addClass('d-none');
                    $publishedAt.prop('disabled', true);
                    $publishedAt.prop('required', false);
                    break;
            }
        }

        $status.on('change', togglePublishedAt);

        togglePublishedAt();
    </script>
@endpush
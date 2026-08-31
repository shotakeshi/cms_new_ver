<form
        id="blog-category"
        method="POST"
        action="{{ isset($isEditMode)
        ? route('blog-categories.update', $blogCategory)
        : route('blog-categories.store')
    }}"
>
    @csrf
    @if (isset($isEditMode))
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @if(isset($languageVersionName))
                        {{ __('site.language_used_update') . ': ' . $languageVersionName }}
                    @else
                        {{ __('site.language_default') . ': ' . $currentLanguage->name }}
                    @endif
                </div>
                <div class="card-body">
                    <x-admin::forms.input
                            name="name"
                            :label="__('site.blog.category.name')"
                            :placeholder="__('site.blog.category.name')"
                            required
                            onkeyup="generateSlug(this)"
                            :small="__('site.blog.name.note')"
                            :value="isset($blogCategoryContent) ? $blogCategoryContent->name : old('name')"
                    />
                    <x-admin::forms.input
                            name="slug"
                            :label="__('site.page.slug')"
                            :placeholder="__('site.page.slug')"
                            required
                            :small="__('site.blog.slug.note')"
                            :value="isset($blogCategoryContent) ? $blogCategoryContent->slug : old('slug')"
                    />
                    <x-admin::forms.select-has-child
                            name="parent_id"
                            label="{{ __('site.blog.parent_category') }}"
                            :options="$availableCategories ?? $blogCategories"
                            :contents="$availableCategoryContents ?? $blogCategoryContents"
                            :locale="$refLang ?? $appLocale"
                            :selected="old('parent_id', $blogCategory->parent_id ?? 0)"
                            select2
                    />
                    <x-admin::forms.textarea
                            name="description"
                            label="{{ __('site.page.description') }}"
                            placeholder="{{ __('site.page.description') }}"
                            rows="5"
                            :value="isset($blogCategoryContent) ? $blogCategoryContent->description : old('name')"
                    />
                    <x-admin::forms.actions
                            :back-url="route('blog-categories.index')"
                            show-reset
                            :showSaveExit="false"
                    />
                </div>
            </div>
        </div>
    </div>
</form>
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
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
    </script>
@endpush
<form id="blog-category" action="{{ route('blog-categories.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ __('site.language_default') . ': ' . $currentLanguage->name }}
                </div>
                <div class="card-body">
                    <x-admin::forms.input
                            name="name"
                            :label="__('site.blog.category.name')"
                            :placeholder="__('site.blog.category.name')"
                            required
                            onkeyup="generateSlug(this)"
                            :small="__('site.blog.name.note')"
                    />

                    <div class="form-group">
                        <label for="slug">{{ __('site.page.slug') }} <span class="text-danger">*</span></label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug') }}" placeholder="{{ __('site.page.slug') }}">
                        <small class="form-text text-muted">{{ __('site.blog.slug.note') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="parent">{{ __('site.blog.parent_category') }}</label>
                        <select id="parent" name="parent_id" class="form-control">
                            <option value="0"> {{ __('site.common.choose') }}</option>
                            @foreach($blogCategories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $blogCategoryContents[$category->id][$appLocale]['name'] ?? '[ ' . array_key_first($blogCategoryContents[$category->id]) . ' ] ' . collect($blogCategoryContents[$category->id])->first()['name'] }}
                                </option>
                                @if($category->children->count())
                                    @php $line = '--' @endphp
                                    @include('admin.blog.category._category-child', [
                                        'children' => $category->children,
                                        'blogCategoryContents' => $blogCategoryContents,
                                        'line' => $line
                                    ])
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('site.page.description') }}</label>
                        <textarea class="form-control" id="description" name="description" placeholder="{{ __('site.page.description') }}" rows="5">{{ old('description') }}</textarea>
                        <small class="form-text text-muted">{{ __('site.blog.description.note') }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <button type="button" onclick="$('#blog-category').submit()" class="btn btn-lg btn-gradient-primary w-100"><i class="far fa-save"></i> {{ __('site.button.save') }}</button>
        </div>
    </div>
</form>
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script>
        function generateSlug(input){
            const slug = document.getElementById("slug");
            slug.value = createSlug(input.value);
        }

        function createSlug(string) {
            return string
                .toString()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-zA-Z0-9\s-]/g, "")
                .trim()
                .replace(/\s+/g, "-")
                .toLowerCase();
        }
    </script>
@endpush
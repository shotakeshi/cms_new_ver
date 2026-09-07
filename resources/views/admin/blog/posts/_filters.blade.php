<div class="row">
    <div class="col-lg-7">
        <form>
            <div class="row">
                <div class="col-lg-4">
                    <x-admin::forms.input
                            name="name"
                            :placeholder="__('site.page.input_name_search')"
                            required
                            onkeyup="generateSlug(this)"
                            :value="request('name')"
                    />
                </div>
                <div class="col-lg-3">
                    <x-admin::forms.select-has-child
                            name="blog_category_id"
                            :options="$availableCategories ?? $blogCategories"
                            :contents="$availableCategoryContents ?? $blogCategoryContents"
                            :locale="$refLang ?? $appLocale"
                            :selected="old('blog_category_id', $category->parent_id ?? 0)"
                            select2
                    />
                </div>
                <div class="col-lg-2">
                    <input type="submit" class="btn btn-outline-primary waves-effect waves-light" value="{{ __('site.blog.posts.search_posts') }}">
                </div>
            </div>
        </form>
    </div>
    <div class="col-5 text-right">
        <x-admin::page-actions
                :create-url="route('blog-posts.create')"
                :reload-url="route('blog-posts.index')"
        />
    </div>
    <div class="col-lg-12">
        <a href="{{ route('pages.index') }}" class="btn btn-sm btn-outline-{{ (!request()->routeIs('pages.trash') && request('status') === null) ? 'primary' : 'gray' }} pl-3 pr-3 mr-2">
            {{ __('site.filter.all') }}
            ({{ collect($statusCounts)->sum() ?? 0 }})
        </a>
        @foreach (\App\Enums\DefaultStatus::cases() as $status)
            <a
                    href="{{ route('pages.index', ['status' => $status->value]) }}"
                    class="btn btn-sm btn-outline-{{ request('status') !== null
                    && (string) request('status') === (string) $status->value ? 'primary' : 'gray' }} pl-3 pr-3 mr-2"
            >
                {{ $status->getName() }}
                ({{ $statusCounts[$status->value] ?? 0 }})
            </a>
        @endforeach
        <a
                href="{{ route('pages.trash') }}"
                class="btn btn-sm btn-outline-{{ request()->routeIs('pages.trash') ? 'primary' : 'gray' }} pl-3 pr-3"
        >
            {{ __('site.filter.trash') }}
            ({{ $statusCounts['trashed'] ?? 0 }})
        </a>
    </div>
</div>

@foreach($blogCategoryChildrens as $blogCategory)
    <tr class="hover-target" id="row-{{ $blogCategory->id}}" >
        <td>
            <div class="mb-1">
                <a href="{{ route('blog-categories.edit', $blogCategory) }}?ref_lang={{ app()->getLocale() }}">
                    <span class="font-14 text-primary">{{ $line }} {{ $blogCategoryContents[$blogCategory->id][$appLocale]['name'] ?? '[ ' . array_key_first($blogCategoryContents[$blogCategory->id]) . ' ] ' . collect($blogCategoryContents[$blogCategory->id])->first()['name'] }}</span>
                </a>
            </div>
            <div style="height: 22px">
                <div class="row-action hidden-div">
                    <a class="border-right text-primary border-gray pr-2 mr-1" href="{{ route('blog-categories.edit', $blogCategory) }}">{{ __('site.button.edit') }}</a>
                    <a class="text-danger border-gray pr-2 mr-1 btn-delete"
                       href="#"
                       data-toggle="modal"
                       data-target="#deleteModal"
                       data-animation="bounce"
                       data-url="{{ route('blog-categories.destroy', $blogCategory) }}"
                       data-name="{{ $blogCategoryContents[$blogCategory->id][$appLocale]['name'] ?? '[ ' . array_key_first($blogCategoryContents[$blogCategory->id]) . ' ] ' . collect($blogCategoryContents[$blogCategory->id])->first()['name'] }}">{{ __('site.button.delete_permanently') }}
                    </a>
                </div>
            </div>
        </td>
        <td class="text-center">
            @foreach($globalLanguages as $language)
                @if(!empty($blogCategoryContents[$blogCategory->id][$language->slug]))
                    <a href="{{ route('blog-categories.edit', $blogCategory) }}?ref_lang={{ $language->slug }}">
                        <i class="font-20 mdi mdi-square-edit-outline text-success"></i>
                    </a>
                @else
                    <a href="{{ route('blog-categories.edit', $blogCategory) }}?ref_lang={{ $language->slug }}">
                        <i class="font-20 mdi mdi-shape-square-plus text-primary"></i>
                    </a>
                @endif
            @endforeach
        </td>
        <td class="text-right">
            <span class="text-gray font-italic">{{ __('site.page.created_at') }}: </span>
            <span class="text-primary">{{ $blogCategory->created_at }}</span><br/>
            <span class="text-gray font-italic">{{ __('site.button.last_modified') }}: </span>
            <span class="text-beanred">{{ $blogCategory->updated_at }}</span>
        </td>
    </tr>
    @if($blogCategory->children->count())
        @include('admin.blog.category._table-category-child', [
            'blogCategoryChildrens' => $blogCategory->children,
            'blogCategoryContents' => $blogCategoryContents,
            'line' => $line.$line
        ])
    @endif
@endforeach

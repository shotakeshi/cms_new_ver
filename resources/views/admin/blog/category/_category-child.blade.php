@foreach($children as $child)
    <option value="{{ $child->id }}">
    {{ $line }} {{ $blogCategoryContents[$child->id][$appLocale]['name'] ?? '[ ' . array_key_first($blogCategoryContents[$child->id]) . ' ] ' . collect($blogCategoryContents[$child->id])->first()['name'] }}
    @if($child->children->count())
        @include('admin.blog.category._category-child', [
            'children' => $child->children,
            'blogCategoryContents' => $blogCategoryContents,
            'line' => $line.$line
        ])
    @endif
</option>
@endforeach

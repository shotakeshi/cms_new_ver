{{-- How to use --}}
{{--
<x-admin::forms.category-select
    name="parent_id"
    label="{{ __('site.blog.parent_category') }}"
    :options="$blogCategories"
    :contents="$blogCategoryContents"
    :locale="$appLocale"
    :selected="old('parent_id', $blogCategory->parent_id ?? 0)"
/>
--}}

@props([
    'name' => 'parent_id',
    'label' => null,
    'options' => [],
    'contents' => [],
    'locale' => null,
    'selected' => 0,
    'placeholder' => null,
    'required' => false,
    'select2' => false,
])

@php
    $selected = old($name, $selected);
    $getCategoryName = function ($category) use ($contents, $locale) {
        $categoryContents = $contents[$category->id] ?? [];

        if (!$categoryContents) {
            return $category->name ?? '';
        }

        return $categoryContents[$locale]['name']
            ?? (
                !empty($categoryContents)
                    ? '[ ' . array_key_first($categoryContents) . ' ] '
                        . collect($categoryContents)->first()['name']
                    : ''
            );
    };

    $renderOptions = function ($categories, $prefix = '') use (
        &$renderOptions,
        $getCategoryName,
        $selected
    ) {
        foreach ($categories as $category) {
            $value = $category->id;
            $label = $prefix . $getCategoryName($category);

            echo '<option value="' . e($value) . '" '
                . ($selected == $value ? 'selected' : '')
                . '>'
                . e($label)
                . '</option>';

            if ($category->children->isNotEmpty()) {
                $renderOptions(
                    $category->children,
                    $prefix . '-- '
                );
            }
        }
    };
@endphp

<div class="form-group">

    @if ($label)
        <label for="{{ $name }}" class="col-form-label">
            {{ $label }}

            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select
            id="{{ $name }}"
            name="{{ $name }}"
            @class([
                'form-control',
                'is-invalid' => $errors->has($name),
                'select2' => $select2,
            ])
            @if ($required) required @endif
            {{ $attributes }}
    >

        <option value="0">
            {{ $placeholder ?? __('site.common.choose') }}
        </option>

        @php
            $renderOptions($options);
        @endphp

    </select>

    @error($name)
    <div class="form-control-feedback text-danger">
        {{ $message }}
    </div>
    @enderror

</div>
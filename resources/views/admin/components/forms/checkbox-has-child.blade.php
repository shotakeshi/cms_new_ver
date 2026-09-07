{{-- How to use --}}
{{--
<x-admin::forms.category-checkbox
    name="category_ids"
    label="{{ __('site.blog.categories') }}"
    :options="$blogCategories"
    :contents="$blogCategoryContents"
    :locale="$appLocale"
    :selected="old('category_ids', $selectedCategoryIds ?? [])"
/>
--}}

@props([
    'name' => 'category_ids',
    'label' => null,
    'options' => [],
    'contents' => [],
    'locale' => null,
    'selected' => [],
    'required' => false,
])

@php
    /*
     * Make sure selected is always an array.
     */
    $selected = old($name, $selected);

    if (!is_array($selected)) {
        $selected = [$selected];
    }

    $selected = array_map('strval', $selected);

    /*
     * Get category name by locale.
     */
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
                    : ($category->name ?? '')
            );
    };

    /*
     * Generate unique checkbox ID.
     */
    $getCheckboxId = function ($category) use ($name) {
        return $name . '_' . $category->id;
    };

    /*
     * Render category tree.
     */
    $renderOptions = function (
        $categories,
        $level = 0
    ) use (
        &$renderOptions,
        $getCategoryName,
        $getCheckboxId,
        $selected
    ) {
        foreach ($categories as $category) {
            $id = $getCheckboxId($category);
            $value = (string) $category->id;
            $label = $getCategoryName($category);

            $isChecked = in_array($value, $selected, true);

            $hasChildren = $category->children->isNotEmpty();

            $class = match ($level) {
                1 => 'checkbox-primary',
                2 => 'checkbox-success',
                default => '',
            };
            ?>

            <div
                class="checkbox {{ $class }}"
                style="margin-left: {{ $level * 24 }}px;"
            >
                <input
                    id="{{ $id }}"
                    type="checkbox"
                    name="{{ $name }}[]"
                    value="{{ $value }}"
                    @checked($isChecked)
                    @if($required) required @endif
                >

                <label for="{{ $id }}">
                    {{ $label }}
                </label>
            </div>

            <?php
            if ($hasChildren) {
                $renderOptions(
                    $category->children,
                    $level + 1
                );
            }
        }
    };
@endphp

<div class="form-group">

    @if ($label)
        <label class="col-form-label">
            {{ $label }}

            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="category-checkbox-list">
        @php
            $renderOptions($options);
        @endphp
    </div>

    @error($name)
    <div class="form-control-feedback text-danger">
        {{ $message }}
    </div>
    @enderror

</div>
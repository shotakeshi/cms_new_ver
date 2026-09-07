{{-- resources/views/components/admin/forms/checkbox-has-child.blade.php --}}

{{-- How to use --}}
{{--
<x-admin::forms.checkbox-has-child
    name="category_ids"
    :label="__('site.blog.categories')"
    :options="$blogCategories"
    :contents="$blogCategoryContents"
    :locale="$appLocale"
    :selected="$selectedCategoryIds ?? []"
    :required="true"
/>
--}}

@props([
    'name' => null,
    'label' => null,
    'options' => [],
    'contents' => [],
    'locale' => null,
    'selected' => [],
    'required' => false,
])

@php
    /*
     * Normalize selected values.
     */
    $selected = old($name, $selected);
    if (!is_array($selected)) {
        $selected = [$selected];
    }
    $selected = array_map('strval', $selected);
    /*
     * Get item label by locale.
     */
    $getItemLabel = function ($item) use ($contents, $locale): string {
        $itemContents = $contents[$item->id] ?? [];

        /*
         * No translated content.
         */
        if (empty($itemContents)) {
            return $item->name ?? '';
        }

        /*
         * Current locale.
         */
        if (
            $locale !== null &&
            isset($itemContents[$locale]['name'])
        ) {
            return $itemContents[$locale]['name'];
        }

        /*
         * Fallback to first available locale.
         */
        $fallbackLocale = array_key_first($itemContents);

        if ($fallbackLocale !== null) {
            return '[ ' . $fallbackLocale . ' ] '
                . ($itemContents[$fallbackLocale]['name'] ?? '');
        }

        return $item->name ?? '';
    };

    /*
     * Render recursive options.
     */
    $renderOptions = function (
        $items,
        int $level = 0
    ) use (
        &$renderOptions,
        $getItemLabel,
        $selected,
        $name
    ): void {
        foreach ($items as $item) {
            $id = $name . '_' . $item->id;
            $value = (string) $item->id;

            $isChecked = in_array(
                $value,
                $selected,
                true
            );

            $hasChildren = $item->children->isNotEmpty();

            $class = match ($level) {
                1 => 'checkbox-primary',
                2 => 'checkbox-primary',
                default => 'checkbox-primary',
            };

            $marginLeft = $level * 12;

            echo '<div class="checkbox '
                . e($class)
                . '" style="margin-left: '
                . $marginLeft
                . 'px;">';

            echo '<input
                id="' . e($id) . '"
                type="checkbox"
                name="' . e($name) . '[]"
                value="' . e($value) . '"
                ' . ($isChecked ? 'checked' : '') . '
            >';

            echo '<label for="' . e($id) . '">'
                . e($getItemLabel($item))
                . '</label>';

            echo '</div>';

            /*
             * Render children recursively.
             */
            if ($hasChildren) {
                $renderOptions(
                    $item->children,
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
{{-- How to use --}}
{{--
<x-admin::forms.multiple-select
    name="slug[]"
    label="{{ __('site.permission.choose_permission') }}"
    :options="$routeNames"
    :selected="$permission->slug"
    :disabled-values="$permissionExists"
    placeholder="{{ __('site.permission.choose') }}"
/>
--}}

@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => [],
    'disabledValues' => [],
    'optionValue' => null,
    'optionLabel' => null,
    'placeholder' => null,
    'required' => false,
])

@php
    $fieldName = str_replace('[]', '', $name);
    $selected = old($fieldName, $selected);

    $selected = is_array($selected)
        ? $selected
        : (array) $selected;

    $disabledValues = is_array($disabledValues)
        ? $disabledValues
        : (array) $disabledValues;

    $selectedValues = array_map('strval', $selected);
    $disabledValueList = array_map('strval', $disabledValues);

    $isObjectOption = $optionValue !== null || $optionLabel !== null;

    $normalOptions = [];
    $disabledOptions = [];

    foreach ($options as $option) {

        if ($isObjectOption) {
            $value = data_get($option, $optionValue);
            $labelValue = data_get($option, $optionLabel);
        } else {
            $value = $option;
            $labelValue = $option;
        }

        $isSelected = in_array(
            (string) $value,
            $selectedValues,
            true
        );

        $isDisabled = in_array(
            (string) $value,
            $disabledValueList,
            true
        ) && !$isSelected;

        $item = [
            'value' => $value,
            'label' => $labelValue,
            'selected' => $isSelected,
            'disabled' => $isDisabled,
        ];

        if ($isDisabled) {
            $disabledOptions[] = $item;
        } else {
            $normalOptions[] = $item;
        }
    }

    $options = array_merge($normalOptions, $disabledOptions);
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

    <select
            name="{{ $name }}"
            @class([
                'form-control',
                'select2',
                'select2-multiple',
                'is-invalid' => $errors->has($fieldName),
            ])
            multiple
            data-placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            {{ $attributes }}
    >

        @foreach ($options as $option)

            <option
                    value="{{ $option['value'] }}"
                    @selected($option['selected'])
                    @disabled($option['disabled'])
            >
                {{ $option['label'] }}
            </option>

        @endforeach

    </select>

    @error($fieldName)
    <div class="form-control-feedback text-danger">
        {{ $message }}
    </div>
    @enderror

</div>
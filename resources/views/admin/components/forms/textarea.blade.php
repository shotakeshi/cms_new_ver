{{-- How to use --}}
{{--
<x-form.textarea
    name="description"
    label="{{ __('site.department.description') }}"
    placeholder="{{ __('site.department.description') }}"
    :value="$department->description ?? null"
    rows="5"
/>
--}}

@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'rows' => 5,
    'required' => false,
    'disabled' => false,
    'ckeditor' => false,
])

@php
    $fieldValue = old($name, $value);
@endphp

<div class="form-group">

    @if ($label)
        <label
                for="{{ $name }}"
                class="col-form-label"
        >
            {{ $label }}

            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder ?? $label }}"
            @class([
                'form-control',
                'is-invalid' => $errors->has($name),
                'ckeditor' => $ckeditor,
            ])
            @if ($disabled) disabled @endif
            {{ $attributes }}
    >{{ $fieldValue }}</textarea>

    @error($name)
        <div class="form-control-feedback text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
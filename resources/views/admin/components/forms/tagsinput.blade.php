{{-- How to use --}}
{{--
<x-form.tagsinput
    name="meta_keywords"
    label="{{ __('site.page.meta_keywords') }}"
    :value="$page->meta_keywords ?? null"
    placeholder="{{ __('site.page.meta_keywords') }}"
/>
--}}

@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
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
    <div class="u-tagsinput">
        <input
                type="text"
                id="{{ $name }}"
                name="{{ $name }}"
                class="form-control @error($name) is-invalid @enderror"
                data-role="tagsinput"
                value="{{ $fieldValue }}"
                placeholder="{{ $placeholder ?? $label }}"
                @if ($required) required @endif
                @if ($disabled) disabled @endif
                {{ $attributes }}
        >
        @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
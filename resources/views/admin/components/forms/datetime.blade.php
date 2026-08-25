{{-- How to use --}}
{{--
<x-form.datetime
    name="published_at"
    label="{{ __('site.page.published_at') }}"
    :value="$page->published_at ?? null"
    placeholder="dd/mm/yyyy - hh:mm"
/>
--}}

@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => 'dd/mm/yyyy - hh:mm',
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

    <input
            type="text"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $fieldValue }}"
            placeholder="{{ $placeholder }}"
            @class([
                'form-control',
                'is-invalid' => $errors->has($name),
            ])
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
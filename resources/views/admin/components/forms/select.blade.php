@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'optionValue' => 'value',
    'optionLabel' => 'label',
    'placeholder' => null,
    'select2' => false,
    'required' => false,
])

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

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @class([
            'form-control',
            'select2' => $select2,
            'is-invalid' => $errors->has($name),
        ])
        {{ $attributes }}
    >

        @if ($placeholder)
            <option value="">
                {{ $placeholder }}
            </option>
        @endif

        @foreach ($options as $option)
            @php
                $value = data_get($option, $optionValue);
                $labelValue = data_get($option, $optionLabel);
            @endphp
            <option
                    value="{{ $value }}"
                    {{ old($name, $selected) == $value ? 'selected' : '' }}
            >
                {{ $labelValue }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="form-control-feedback text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
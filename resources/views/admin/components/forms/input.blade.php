@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'required' => false,
])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="col-form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder ?? $label }}"
            @class([ 'form-control','is-invalid' => $errors->has($name) ])
            {{ $attributes }}
    >

    @error($name)
        <div id="messages-{{ $name }}" class="form-control-feedback text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
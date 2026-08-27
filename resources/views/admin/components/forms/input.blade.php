@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'small' => null
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
    @if ($small)
        <small class="form-text text-muted">{{ $small }}</small>
    @endif
    <div id="messages-{{ $name }}" class="form-control-feedback text-danger" @if (!$errors->has($name)) style="display: none;" @endif>
        @error($name)
            {{ $message }}
        @enderror
    </div>
</div>
@props([
    'name',
    'label' => null,
    'accept' => null,
    'defaultFile' => null,
])

@if ($label)
    <label for="{{ $name }}" class="col-form-label">
        {{ $label }}
    </label>
@endif

<input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        class="dropify @error($name) is-invalid @enderror"
        @if($accept) accept="{{ $accept }}" @endif
        @if($defaultFile) data-default-file="{{ $defaultFile }}" @endif
/>

@error($name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
@enderror
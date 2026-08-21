{{--How to use--}}
{{--<x-form.radio-buttons--}}
{{--        name=""--}}
{{--        :options=""--}}
{{--        :selected=""--}}
{{--/>--}}
@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
])
@php
    $selected = old($name, $selected);
@endphp

<div class="form-group">

    @if ($label)
        <label class="col-form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label><br>
    @endif
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        @foreach ($options as $option)
            @php
                $value = data_get($option, 'value');
                $optionLabel = data_get($option, 'label');

                $checked = $selected !== null
                    ? $selected === $value
                    : $loop->first;
            @endphp

            <label class="btn btn-outline-primary {{ $checked ? 'active' : '' }}">
                <input
                        type="radio"
                        name="{{ $name }}"
                        value="{{ $value }}"
                        autocomplete="off"
                        @checked($checked)
                        @if ($required) required @endif
                >
                {{ $optionLabel }}
            </label>

        @endforeach

    </div>

    @error($name)
    <div class="form-control-feedback text-danger">
        {{ $message }}
    </div>
    @enderror

</div>
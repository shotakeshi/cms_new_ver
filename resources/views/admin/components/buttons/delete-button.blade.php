@props([
    'action',
    'title' => null,
    'asText' => false,
])
@php
    use Illuminate\Support\Str;
    $formId = 'delete-form-' . Str::uuid();
@endphp
<form
        id="{{ $formId }}"
        action="{{ $action }}"
        method="POST"
        class="d-inline"
>
    @csrf
    @method('DELETE')
    @if ($asText)
        <a
                href="javascript:void(0)"
                class="text-danger"
                onclick="confirmDelete('{{ $formId }}')"
                title="{{ __('site.button.delete_permanently') }}"
        >
            {{ $title ?? __('site.button.delete_permanently') }}
        </a>

    @else
        <button
                type="button"
                class="btn btn-outline-danger"
                onclick="confirmDelete('{{ $formId }}')"
                title="{{ __('site.button.delete') }}"
        >
            <i class="fas fa-trash"></i>
        </button>
    @endif
</form>
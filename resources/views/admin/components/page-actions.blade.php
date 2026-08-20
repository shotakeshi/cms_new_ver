@props([
    'createUrl' => null,
    'reloadUrl' => null,
])
@if ($createUrl)
    <a href="{{ $createUrl }}" class="btn btn-outline-primary px-5 waves-effect waves-light">
        <i class="fa fa-plus mr-1"></i>
        {{ __('site.button.create') }}
    </a>
@endif
@if ($reloadUrl)
    <a href="{{ $reloadUrl }}" class="btn btn-outline-danger px-5 waves-effect waves-light ml-2">
        <i class="fas fa-redo mr-1"></i>
        {{ __('site.button.reload') }}
    </a>
@endif

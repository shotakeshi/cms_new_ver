@props([
    'name',
    'url' => null,
])
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            {{ __('site.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $name }}
                    </li>
                </ol>
            </div>
            <h4 class="page-title">
                @if ($url)
                    <a href="{{ $url }}" class="btn btn-sm btn-outline-warning waves-effect waves-light ml-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        {{ __('site.button.back') }}
                    </a>
                @endif
            </h4>
        </div>
    </div>
</div>
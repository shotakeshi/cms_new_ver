<div class="row">
    <div class="col-lg-7">
        {{-- All --}}
        <a href="{{ route('landing-pages.index') }}" class="btn btn-outline-{{ (!request()->routeIs('pages.trash') && request('status') === null) ? 'primary' : 'gray' }} pl-3 pr-3 mr-2">
            {{ __('site.filter.all') }}
            ({{ collect($statusCounts)->sum() ?? 0 }})
        </a>
        {{-- Status --}}
        @foreach (\App\Enums\DefaultStatus::cases() as $status)
            <a
                href="{{ route('landing-pages.index', ['status' => $status->value]) }}"
                class="btn btn-outline-{{ request('status') !== null
                && (string) request('status') === (string) $status->value ? 'primary' : 'gray' }} pl-3 pr-3 mr-2"
            >
                {{ $status->getName() }}
                ({{ $statusCounts[$status->value] ?? 0 }})
            </a>
        @endforeach
        {{-- Trash --}}
        <a
            href="{{ route('landing-pages.trash') }}"
            class="btn btn-outline-{{ request()->routeIs('pages.trash') ? 'primary' : 'gray' }} pl-3 pr-3"
        >
            {{ __('site.filter.trash') }}
            ({{ $statusCounts['trashed'] ?? 0 }})
        </a>
    </div>
    <div class="col-5 text-right">
        <x-admin::page-actions
                :create-url="route('landing-pages.create')"
                :reload-url="route('landing-pages.index')"
        />
    </div>
</div>
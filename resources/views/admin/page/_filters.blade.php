<div class="row">
    <div class="col-sm-7">
        <form class="form-inline">
            <div class="form-group">
                <input class="form-control" style="width: 350px" placeholder="{{ __('site.page.input_name_search') }}" name="name" value="{{ request('name') }}">
                <input type="submit" class="ml-3 btn btn-outline-primary waves-effect waves-light" value="{{ __('site.page.search_pages') }}">
            </div>
        </form>
    </div>
    <div class="col-5 text-right">
        <x-admin::page-actions
                :create-url="route('pages.create')"
                :reload-url="route('pages.index')"
        />
    </div>
    <div class="col-lg-12 mt-3">
        {{-- All --}}
        <a href="{{ route('pages.index') }}" class="btn btn-sm btn-outline-{{ (!request()->routeIs('pages.trash') && request('status') === null) ? 'primary' : 'gray' }} pl-3 pr-3 mr-2">
            {{ __('site.filter.all') }}
            ({{ $statusCounts['all'] ?? 0 }})
        </a>
        {{-- Status --}}
        @foreach (\App\Enums\DefaultStatus::cases() as $status)
            <a
                    href="{{ route('pages.index', ['status' => $status->value]) }}"
                    class="btn btn-sm btn-outline-{{ request('status') !== null
                    && (string) request('status') === (string) $status->value ? 'primary' : 'gray' }} pl-3 pr-3 mr-2"
            >
                {{ $status->getName() }}
                ({{ $statusCounts[$status->value] ?? 0 }})
            </a>
        @endforeach
        {{-- Trash --}}
        <a
                href="{{ route('pages.trash') }}"
                class="btn btn-sm btn-outline-{{ request()->routeIs('pages.trash') ? 'primary' : 'gray' }} pl-3 pr-3"
        >
            {{ __('site.filter.trash') }}
            ({{ $statusCounts['trashed'] ?? 0 }})
        </a>
    </div>
</div>
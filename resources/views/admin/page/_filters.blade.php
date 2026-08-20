<div class="row">
    <div class="col-sm-7 mb-3">
        <a class="border-right border-gray pr-2 mr-1" href="{{ route('pages.index') }}">{{ __('site.filter.all') }} ({{ collect($statusCounts)->sum() }})</a>
        @foreach(\App\Enums\DefaultStatus::cases() as $status)
            <a class="border-right border-gray pr-1 mr-2" href="{{ route('pages.index') }}?status={{ $status->value }}">
                {{ \App\Enums\DefaultStatus::from($status->value)->getName() }} ({{ $statusCounts[$status->value] ?? 0 }})
            </a>
        @endforeach
        <a href="{{ route('pages.trash') }}">{{ __('site.filter.trash') }} ({{ $statusCounts['trashed'] ?? 0 }})</a>
        <form class="form-inline mt-2">
            <div class="form-group">
                <input class="form-control" name="name" value="{{ request('name') }}">
                <input type="submit" class="ml-2 btn btn-outline-primary" value="{{ __('site.page.search_pages') }}">
            </div>
        </form>
    </div>
    <div class="col-5 text-right pt-3">
        <a class="btn btn-gradient-primary waves-effect waves-light px-5" href="{{ route('pages.create') }}">
            <i class="fa fa-plus"></i> {{ __('site.button.create') }}
        </a>
        <a class="btn btn btn-gradient-dark waves-effect waves-light px-5 ml-2" href="{{ route('pages.index') }}">
            <i class="fas fa-redo"></i> {{ __('site.button.reload') }}
        </a>
    </div>
</div>
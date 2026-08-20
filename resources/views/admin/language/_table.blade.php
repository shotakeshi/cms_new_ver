<div class="card m-b-30">
    <div class="card-body">
        <h4 class="mt-0 header-title">{{ __('site.language.list') }}</h4>
        <p class="text-muted mb-3"> {{ __('site.language.note') }}</p>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>{{ __('site.language.name') }}</th>
                    <th>{{ __('site.language.slug') }}</th>
                    <th>{{ __('site.language.code') }}</th>
                    <th class="text-center">{{ __('site.language.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($languages as $language)
                        <tr id="row-{{ $language->id }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $language->name }}</td>
                            <td>{{ $language->slug }}</td>
                            <td>{{ $language->code }}</td>
                            <td class="text-center">
                                <span class="{{ $language->status_class }}">{{ $language->status_name  }}</span>
                            </td>
                            <td class="text-right">
                                <div class="actions">
                                    <a class="btn btn-sm btn-gradient-success" style="width: 32px"
                                       href="{{ route('languages.edit', $language) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-gradient-danger" style="width: 32px" onclick="confirmDelete( {{ $language->id }}, '{{ route('languages.destroy', $language) }}' )">
                                        <i class="dripicons-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
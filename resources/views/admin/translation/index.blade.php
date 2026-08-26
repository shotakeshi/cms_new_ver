@extends('admin.layouts.app')
@section('title')
    {{ __('site.translation.title') }}
@endsection
@push('styles')
    <!-- X-editable css -->
    <link href="{{ asset('administrator/plugins/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.translation.title')"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h4 class="mt-0 header-title">{{ __('site.translation.list') }}</h4>
                                <p class="text-muted mb-3">
                                    {{ __('site.translation.note') }}
                                </p>
                            </div>
                            <div class="col-sm-8 text-right">
                                <a class="btn btn-outline-primary waves-effect waves-light px-5" href="{{ route('translation.create') }}">
                                    <i class="fa fa-plus"></i> {{ __('site.button.create') }}
                                </a>
                                <a class="btn btn-outline-danger waves-effect waves-light px-5" href="{{ route('translation.index') }}">
                                    <i class="fas fa-redo"></i> {{ __('site.button.reload') }}
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-5">
                                <form method="GET" class="form-inline">
                                    <div class="form-group">
                                        <input class="form-control" name="keyword" value="{{ request('keyword') }}">
                                        <input type="submit" class="ml-2 btn btn-outline-primary" value="{{ __('site.translation.search_title') }}">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-7">
                                <div class="text-end d-flex justify-content-end align-items-center">
                                    <h4 class="my-0 mr-2 header-title">Translations: </h4>
                                    @foreach($globalLanguages as $language)
                                        @if($language->slug != $locale)
                                            <div>
                                                <a href="{{ route('translation.index') }}?ref_lang={{ $language->slug }}" class="d-flex align-items-center">
                                                    <img alt="{{ $language->name }}" class="mr-1" style="max-width: 25px" src="{{ asset('flags/'.$language->slug.'.png') }}">
                                                    <span>{{ $language->name }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Key</th>
                                    <th style="width:60%">Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($translations as $keyTrans => $valueTrans)
                                    <tr id="row-1">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $keyTrans }}</td>
                                        <td>
                                            <div id="row-translation-{{ $loop->iteration }}" class="w-100">
                                                <a href="#"
                                                   class="editable editable-click editable-empty edit_translation"
                                                   data-type="text"
                                                   data-placeholder="Required"
                                                   data-url="{{ route('translation.update', $locale) }}"
                                                   data-pk="{{ $locale.".".$keyTrans }}"
                                                   data-key="{{ $keyTrans }}"
                                                   data-locale="{{ $locale }}">{{ $valueTrans }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($translations->lastPage() > 1)
                        <div class="card-footer">
                            {{ $translations->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- XEditable Plugin -->
    <script src="{{ asset('administrator/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/plugins/x-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-xeditable.init.js') }}"></script>
    <script>
        $('.edit_translation').editable({
            type: 'text',
            mode: 'inline',
            url: $(this).data('url'),
            params: function(params) {
                params._token = $('meta[name="csrf-token"]').attr('content'),
                params.key = $(this).data('key'),
                params.locale = $(this).data('locale')
                return params;
            },
            success: function(response, newValue) {
                toastr.success('{{ __('site.notification.update_success') }}', "Success");
            },
            error: function(response, newValue) {
                const errors = response.responseJSON?.errors || {};
                toastr.error(errors.value?.[0], '{{ __('site.notification.update_fail') }}');
            }
        });
    </script>
@endpush
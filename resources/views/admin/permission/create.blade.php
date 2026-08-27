@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.permission.create_title')"
                :url="route('permissions.index')"
        />
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="card mb-3">
                        <div class="card-header">
                            {{ __('site.permission.create_title') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.input
                                    name="name"
                                    :label="__('site.permission.name')"
                                    :placeholder="__('site.permission.name')"
                                    required
                            />
                            <x-admin::forms.multiple-select
                                    name="slug[]"
                                    label="{{ __('site.permission.choose_permission') }}"
                                    :options="$routeNames"
                                    :disabled-values="$permissionExists"
                                    placeholder="{{ __('site.permission.choose') }}"
                            />
                            <x-admin::forms.actions
                                    :back-url="route('permissions.index')"
                                    show-reset
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
@endpush
@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission_group.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.permission_group.edit_title')"
                :url="route('permission-groups.index')"
        />
        <form action="{{ route('permission-groups.update', $permissionGroup) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="card mb-3">
                        <div class="card-header">
                            {{ __('site.permission_group.edit_title') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.input
                                    name="name"
                                    :label="__('site.permission_group.name')"
                                    :placeholder="__('site.permission_group.name')"
                                    :value="$permissionGroup->name"
                                    required
                            />
                            <x-admin::forms.multiple-select
                                    name="permission_id[]"
                                    label="{{ __('site.permission.choose_permission') }}"
                                    :options="$permissions"
                                    :selected="$permissionGroup->permission_id ?? []"
                                    option-label="name"
                                    option-value="id"
                                    placeholder="{{ __('site.permission.choose_permission') }}"
                            />
                            <x-admin::forms.actions
                                    :back-url="route('permission-groups.index')"
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
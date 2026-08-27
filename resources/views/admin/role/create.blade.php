@extends('admin.layouts.app')
@section('title')
    {{ __('site.role.title') }}
@endsection
@push('styles')
    <link href="{{ asset('administrator/phoenix/assets/css/role.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.role.create_title')"
                :url="route('roles.index')"
        />
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <x-admin::forms.input
                                    name="name"
                                    :label="__('site.role.name')"
                                    :placeholder="__('site.role.name')"
                                    required
                            />
                        </div>
                    </div>
                    <div class="card m-b-30">
                        <div class="card-header">
                            {{ __('site.role.permissions') }}
                        </div>
                        <div class="card-body">
                            <div class="card-title pb-3">
                                <div class="d-flex ml-auto pr-2">
                                    <div class="checkbox checkbox-primary form-check-inline">
                                        <input type="checkbox" id="allTreeChecked">
                                        <label class="badge-custom badge bg-primary-lt" for="allTreeChecked">{{ __('All Permissions') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="permissions-tree col-lg-12" id="checkboxes-permisstions" data-name="foo">
                                    <ul class="parent_tree m-0 p-0 list-unstyled" id="node1">
                                        @forelse($permissionGroups as $permissionGroup)
                                            <li class="permissions-item list-unstyled">
                                                <div class="permissions-header">
                                                    <div class="checkbox checkbox-primary form-check-inline">
                                                        <input type="checkbox" id="checkbox_group_{{ $permissionGroup->id }}" class="custom-control-input" value="{{ $permissionGroup->id }}">
                                                        <label class="badge-custom badge bg-primary-lt" for="checkbox_group_{{ $permissionGroup->id }}">{{ $permissionGroup->name }}</label>
                                                    </div>
                                                </div>
                                                <ul class="row permissions-body has-children treeview">
                                                    @foreach($permissionGroup->permission_id as $permission_id)
                                                        <li class="list-unstyled col-4 m-0" id="node_sub_1_0">
                                                            <div class="checkbox checkbox-primary form-check-inline">
                                                                <input type="checkbox" id="checkbox_{{ $permission_id }}" name="permission_ids[]" class="custom-control-input" value="{{ $permission_id }}">
                                                                <label class="badge-custom badge bg-primary-lt" for="checkbox_{{ $permission_id }}">{{ $permissions[$permission_id] }}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @empty
                                            <div class="col-12 text-center">
                                                No data found
                                            </div>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
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
    <script>
        $("#checkboxes-permisstions :checkbox").on("click", (function(e) {
            e.stopPropagation();
            let checkboxCurrent = $(e.currentTarget),
                checked = checkboxCurrent.is(":checked"),
                listItemPermission = checkboxCurrent.closest("li"),
                parentListPermissions = listItemPermission.parents("ul");

            listItemPermission.find(":checkbox").prop("checked", checked);

            parentListPermissions.each((function() {
                let parentCurrent = $(this),
                    allChecked = parentCurrent.find(":checkbox").length == parentCurrent.find(":checked").length;
                parentCurrent.siblings().find(":checkbox").prop("checked", allChecked)
            }));
        }));

        $("#allTreeChecked:checkbox").on("click", (function(e) {
            e.stopPropagation();
            let checkboxCurrent = $(e.currentTarget).is(":checked");

            $("#checkboxes-permisstions").length && $("#checkboxes-permisstions").find(":checkbox").prop("checked", checkboxCurrent).each((function() {
                let checkboxAll = $(this),
                    allChecked = checkboxAll.find(":checkbox").length == checkboxAll.find(":checked").length;
                checkboxAll.siblings(":checkbox").prop("checked", allChecked)
            }))
        }));
    </script>
@endpush
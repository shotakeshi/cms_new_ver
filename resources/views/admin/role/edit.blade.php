@extends('admin.layouts.app')
@section('title')
    {{ __('site.role.title') }}
@endsection
@push('styles')
    <link href="{{ asset('administrator/phoenix/assets/css/role.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.role.edit_title'), 'url' => route('roles.index')])
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-group @error('name') is-invalid @enderror">
                                <label>{{ __('site.role.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $role->name) }}" placeholder="{{ __('site.role.name') }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card-title pb-3">
                                <h4 class="m-0 header-title">{{ __('site.role.permissions') }}</h4>
                                <div class="d-flex ml-auto">
                                    <div class="checkbox checkbox-primary form-check-inline">
                                        <input type="checkbox" id="allTreeChecked">
                                        <label class="badge-custom badge bg-primary-lt" for="allTreeChecked">{{ __('All Permissions') }}</label>
                                    </div>
                                    <div id="sideTreeControl" class="side-tree-control ml-3">
                                        <span id="collapseAll">{{ __('site.role.collapse_all') }}</span> | <span id="expandAll">{{ __('site.role.expand_all') }}</span>
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
                                                        <input type="checkbox"
                                                               id="checkbox_group_{{ $permissionGroup->id }}"
                                                               class="custom-control-input"
                                                               @checked(collect($permissionGroup->permission_id)->diff($permissionIds)->isEmpty())
                                                               value="{{ $permissionGroup->id }}">
                                                        <label class="badge-custom badge bg-primary-lt" for="checkbox_group_{{ $permissionGroup->id }}">{{ $permissionGroup->name }}</label>
                                                    </div>
                                                </div>
                                                <ul class="row permissions-body has-children treeview">
                                                    @foreach($permissionGroup->permission_id as $permissionId)
                                                        <li class="list-unstyled col-4 m-0" id="node_sub_1_0">
                                                            <div class="checkbox checkbox-primary form-check-inline">
                                                                <input type="checkbox"
                                                                       id="checkbox_{{ $permissionId }}"
                                                                       name="permission_ids[]"
                                                                       class="custom-control-input"
                                                                       @checked(in_array($permissionId, $permissionIds))
                                                                       value="{{ $permissionId }}">
                                                                <label class="badge-custom badge bg-primary-lt" for="checkbox_{{ $permissionId }}">{{ $permissions[$permissionId] }}</label>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" name="submitter" value="apply" class="btn btn-lg btn-gradient-primary w-100">
                                <i class="far fa-save"></i> {{ __('site.button.save') }}
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="submit" name="submitter" value="save" class="btn btn-lg btn-gradient-purple w-100">
                                <i class="fas fa-sign-out-alt"></i> {{ __('site.button.save_and_exit') }}
                            </button>
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
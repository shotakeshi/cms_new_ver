@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission_group.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.permission_group.title')"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-8">
                            </div>
                            <div class="col-lg-4 text-right">
                                <x-admin::page-actions
                                        :create-url="route('permission-groups.create')"
                                />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 40px">#</th>
                                    <th>{{ __('site.permission_group.name') }}</th>
                                    <th>{{ __('site.permission_group.permissions') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissionGroups as $permissionGroup)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $permissionGroup->name }}</td>
                                        <td>
                                            <ol class="mb-0">
                                                @foreach($permissionGroup->permission_id as $permissionId)
                                                    <li>{{ $permissions[$permissionId]?->name }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td class="text-right">
                                            <div class="actions">
                                                <a class="btn btn-outline-gray"
                                                   href="{{ route('permission-groups.edit', $permissionGroup) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission_group.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.permission_group.title'), 'url' => route('settings.index')])
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h4 class="mt-0 header-title">{{ __('site.permission_group.list') }}</h4>
                                <p class="text-muted mb-3">
                                    {{ __('site.permission_group.note') }}
                                </p>
                            </div>
                            <div class="col-sm-8 text-right">
                                <a class="btn btn-gradient-primary waves-effect waves-light px-5" href="{{ route('permission-groups.create') }}">
                                    <i class="fa fa-plus"></i> {{ __('site.button.create') }}
                                </a>
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
                                                    <li>{{ $permissions[$permissionId] }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td class="text-right">
                                            <div class="actions">
                                                <a class="btn btn-sm btn-gradient-success" style="width: 32px;"
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
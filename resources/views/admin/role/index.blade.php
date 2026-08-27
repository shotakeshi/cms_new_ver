@extends('admin.layouts.app')
@section('title')
    {{ __('site.role.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.role.title')"
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
                                        :create-url="route('roles.create')"
                                />
                            </div>
                        </div>
                         <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('site.role.name') }}</th>
                                        <th>{{ __('site.role.permissions') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <ol class="mb-0">
                                                    @foreach($role->permissions as $permission)
                                                        <li>{{ $permission->name }}</li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td class="text-right">
                                                <div class="actions">
                                                    <a class="btn btn-outline-gray"
                                                       href="{{ route('roles.edit', $role) }}">
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
            </div>
        </div>
    </div>
@endsection
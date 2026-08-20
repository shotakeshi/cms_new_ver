@extends('admin.layouts.app')
@section('title')
    {{ __('site.role.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.role.title'), 'url' => route('settings.index')])
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="mt-0 header-title">{{ __('site.role.list') }}</h4>
                                <p class="text-muted mb-3">
                                    {{ __('site.role.note') }}
                                </p>
                            </div>
                            <div class="col-8 text-right">
                                <a class="btn btn-gradient-primary waves-effect waves-light px-5" href="{{ route('roles.create') }}">
                                    <i class="fa fa-plus"></i> {{ __('site.button.create') }}
                                </a>
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
                                                    <a class="btn btn-sm btn-gradient-success" style="width: 32px"
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
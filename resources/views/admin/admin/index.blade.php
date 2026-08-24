@extends('admin.layouts.app')
@section('title')
    {{ __('site.admin.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
            name="{{ __('site.admin.title') }}"
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
                                    :create-url="route('admins.create')"
                                    :reload-url="route('admins.index')"
                                />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('site.admin.name') }}</th>
                                        <th>{{ __('site.admin.information') }}</th>
                                        <th class="text-center">{{ __('site.admin.locale') }}</th>
                                        <th class="text-center">{{ __('site.admin.status') }}</th>
                                        <th class="text-center">{{ __('site.admin.type_name') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($admins as $admin)
                                        <tr id="row-{{ $admin->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('admins.show', $admin) }}">{{ $admin->name }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admins.show', $admin) }}">
                                                    <span>{{ __('site.admin.email') }}: <label class="text-danger italic font-italic mb-0"> {{ $admin->email }}</label></span><br>
                                                    <span>{{ __('site.admin.phone') }}: <label class="text-danger mb-0">{{ $admin->phone }}</label></span><br>
                                                    <span>{{ __('site.department.title') }}: {{ $admin->department?->name }}</span><br>
                                                    <span>{{ __('site.department.position') }}: {{ $admin->position?->name }}</span>
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $admin->language?->name }}</td>
                                            <td class="text-center">
                                                <span class="{{ $admin->status_class }} w-100 p-1">{{ $admin->status_name  }}</span>
                                            </td>
                                            <td class="text-center">
                                               <span class="{{ $admin->admin_type_class }} w-100 p-1">{{ $admin->admin_type_name  }}</span>
                                            </td>
                                            <td class="text-right">
                                                <div class="actions">
                                                    @if($admin->rootAdmin)
                                                        <a class="btn btn-outline-info" href="{{ route('admin.remove-root-admin', $admin) }}">{{ __('site.button.remove_root') }}</a>
                                                    @endif
                                                    <a class="btn btn-outline-info"
                                                       href="{{ route('admins.show', $admin) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <x-admin::buttons.delete-button
                                                            :action="route('admins.destroy',$admin)"
                                                    />
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                {{ __('common.messages.no_data') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection

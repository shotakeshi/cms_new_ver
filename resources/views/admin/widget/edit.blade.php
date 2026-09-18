@extends('admin.layouts.app')
@section('title')
    {{ __('site.department.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.department.title_edit')"
        />
        <form action="{{ route('departments.update', $department) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            {{ __('site.department.title_edit') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.input
                                    name="name"
                                    label="{{ __('site.department.name') }}"
                                    placeholder="{{ __('site.department.name') }}"
                                    :value="$department->name"
                                    required
                            />
                            <x-admin::forms.textarea
                                    name="description"
                                    label="{{ __('site.department.description') }}"
                                    placeholder="{{ __('site.department.description') }}"
                                    rows="5"
                                    :value="$department->description"
                            />
                            <x-admin::forms.actions
                                    :back-url="route('departments.index')"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            {{ __('site.admin.list') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="20">#</th>
                                            <th>{{ __('site.department.name') }}</th>
                                            <th style="width: 400px">{{ __('site.department.positions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department->admins as $admin)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->position->name ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card m-b-30">
                        <div class="card-header">
                            {{ __('site.department.positions') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="20">#</th>
                                            <th style="width: 400px">{{ __('site.department.positions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department->positions as $k => $v)
                                            <tr>
                                                <td class="text-center" width="20">{{ $loop->iteration }}</td>
                                                <td>{{ $v->name ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
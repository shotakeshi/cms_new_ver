@extends('admin.layouts.app')
@section('title')
    {{ __('site.department.title') }}
@endsection
@push('styles')
    <!-- X-editable css -->
    <link href="{{ asset('administrator/plugins/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.department.title')"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-12 text-right">
                                <x-admin::page-actions
                                        :create-url="route('departments.create')"
                                        :reload-url="route('departments.index')"
                                />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('site.department.name') }}</th>
                                    <th style="width: 400px">{{ __('site.department.positions') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($departments as $department)
                                    <tr id="row-{{ $department->id }}">
                                        <td style="width: 100px">{{ $loop->iteration }}</td>
                                        <td style="width: 300px">
                                            <span>{{ $department->name }}</span><br>
                                            <span class="font-italic text-black-50">{!! $department->description !!}</span>
                                        </td>
                                        <td>
                                            @foreach($department->positions as $k => $v)
                                                <div id="row-position-{{ $v->id }}" class="w-100 d-flex justify-content-between align-items-center mb-2">
                                                    <a href="#"
                                                       class="editable editable-click editable-empty edit_position"
                                                       data-type="text"
                                                       data-placeholder="Required"
                                                       data-pk="{{ $v->id }}"
                                                       data-url="{{ route('department.update-position', $v->id) }}"
                                                       data-title="Enter position name">{{ $v->name }}</a>
                                                        <x-admin::buttons.delete-button
                                                                :action="route('department.destroy-position',$v->id)"
                                                                :title="__('site.button.label_remove')"
                                                        />
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="text-right" style="width: 350px">
                                            <div class="actions">
                                                @include('admin.department.create-position', compact('department'))
                                                <a class="btn btn-outline-gray"
                                                   href="{{ route('departments.edit', $department) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <x-admin::buttons.delete-button
                                                        :action="route('departments.destroy',$department)"
                                                />
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
        @include('admin.partials._delete_modal')
    </div>
@endsection
@push('scripts')
    <!-- XEditable Plugin -->
    <script src="{{ asset('administrator/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/plugins/x-editable/js/bootstrap-editable.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-xeditable.init.js') }}?v={{ time() }}"></script>
    <script>
        $('.edit_position').editable({
            type: 'text',
            mode: 'inline',
            url: function(params) {
                return $(this).data('url');
            },
            params: function(params) {
                params._token = $('meta[name="csrf-token"]').attr('content');
                return params;
            },
            success: function(response, newValue) {
                toastr.success('{{ __('site.notification.update_success') }}', "Success");
            },
            error: function(response, newValue) {
                const errors = response.responseJSON?.errors || {};
                toastr.error(errors.value?.[0], "Error");
            }
        });
    </script>
@endpush
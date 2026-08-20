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
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.department.title')])
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h4 class="mt-0 header-title">{{ __('site.department.list') }}</h4>
                                <p class="text-muted mb-3">
                                    {{ __('site.department.note') }}
                                </p>
                            </div>
                            <div class="col-sm-8 text-right">
                                <a class="btn btn-gradient-primary waves-effect waves-light px-5" href="{{ route('departments.create') }}">
                                    <i class="fa fa-plus"></i> {{ __('site.button.create') }}
                                </a>
                                <a class="btn btn-gradient-dark waves-effect waves-light px-5" href="{{ route('departments.index') }}">
                                    <i class="fas fa-redo"></i> {{ __('site.button.reload') }}
                                </a>
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
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
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
                                                       <button class="btn btn-sm btn-gradient-danger btn-delete"
                                                               href="#"
                                                               data-toggle="modal"
                                                               data-target="#deleteModal"
                                                               data-animation="bounce"
                                                               data-url="{{ route('department.destroy-position', $v->id) }}"
                                                               data-name="{{ $v->name }}">
                                                            <i class="dripicons-trash"></i> {{ __('site.button.label_remove') }}
                                                       </button>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="text-right" style="width: 350px">
                                            <div class="actions">
                                                @include('admin.department.create-position', compact('department'))
                                                <a class="btn btn-sm btn-gradient-success" style="width: 32px"
                                                   href="{{ route('departments.edit', $department) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-gradient-danger btn-delete"
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal"
                                                        data-animation="bounce"
                                                        data-url="{{ route('departments.destroy', $department->id) }}"
                                                        data-name="{{ $department->name }}">
                                                    <i class="dripicons-trash"></i>
                                                </button>
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
    <script src="{{ asset('administrator/plugins/x-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-xeditable.init.js') }}"></script>
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

        $(document).on('click', '.btn-delete', function () {
            let url = $(this).data('url');
            let name = $(this).data('name');
            $('#deleteForm').attr('action', url);
            $('#deleteMessage').text(
                "{{ __('site.notification.confirm_delete') }}: " + name + " ?"
            );
        });
    </script>
@endpush
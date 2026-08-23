@extends('admin.layouts.app')
@section('title')
    {{ __('site.admin.title') }}
@endsection
@push('styles')
    <link href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
            :name="__('site.admin.create_title')"
            :url="route('admins.index')"
        />
        <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.admin.personal_information') }}
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <x-admin::forms.single_file
                                        name="file"
                                        label="{{ __('site.page.avatar') }}"
                                        accept="image/jpeg,image/png,image/webp"
                                    />
                                </div>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <x-admin::forms.input
                                                    name="name"
                                                    label="{{ __('site.admin.name') }}"
                                                    placeholder="{{ __('site.admin.name') }}"
                                                    required
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.input
                                                    name="email"
                                                    label="{{ __('site.admin.email') }}"
                                                    placeholder="{{ __('site.admin.email') }}"
                                                    required
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.input
                                                    name="phone"
                                                    label="{{ __('site.admin.phone') }}"
                                                    placeholder="{{ __('site.admin.phone') }}"
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.input
                                                    name="password"
                                                    type="password"
                                                    label="{{ __('site.admin.password') }}"
                                                    placeholder="{{ __('site.admin.password') }}"
                                                    required
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.input
                                                    name="password_confirmation"
                                                    type="password"
                                                    label="{{ __('site.admin.password_confirmation') }}"
                                                    placeholder="{{ __('site.admin.password_confirmation') }}"
                                                    required
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.select
                                                    label="{{ __('site.department.title') }}"
                                                    name="department_id"
                                                    :options="$departments"
                                                    option-value="id"
                                                    option-label="name"
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.select
                                                    label="{{ __('site.department.position') }}"
                                                    name="position_id"
                                                    :options="collect()"
                                                    option-value="id"
                                                    option-label="name"
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.radio-enums
                                                    name="status"
                                                    label="{{ __('site.admin.status') }}"
                                                    :options="\App\Enums\AdminStatus::options()"
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-admin::forms.radio-buttons
                                                    label="{{ __('site.admin.locale') }}"
                                                    name="language_id"
                                                    :options="$languages"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-admin::forms.actions
                                    :back-url="route('admins.index')"
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
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script>
        $(document).ready(function () {
            const departments = @json($departments);
            const $department = $('#department_id');
            const $position = $('#position_id');
            const selectedPosition = @json(old('position_id', $employee->position_id ?? null)
        );
            function loadPositions(departmentId, selectedId = null) {
                $position.empty();

                if (!departmentId) {
                    $position.val('').trigger('change');
                    return;
                }

                const department = departments.find(
                    department => String(department.id) === String(departmentId)
                );

                if (!department || !department.positions) {
                    $position.val('').trigger('change');
                    return;
                }

                department.positions.forEach(function (position) {
                    const option = new Option(
                        position.name,
                        position.id,
                        false,
                        String(position.id) === String(selectedId)
                    );

                    $position.append(option);
                });

                $position.trigger('change');
            }

            $department.on('change', function () {
                loadPositions($(this).val());
            });

            // Load positions khi Edit / validation error
            if ($department.val()) {
                loadPositions(
                    $department.val(),
                    selectedPosition
                );
            }
        });
    </script>
@endpush
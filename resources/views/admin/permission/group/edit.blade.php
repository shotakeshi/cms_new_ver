@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission_group.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.permission_group.edit_title'), 'url' => route('permission-groups.index')])
        <form action="{{ route('permission-groups.update', $permissionGroup) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-group ">
                                <label for="name" class="col-form-label">{{ __('site.permission_group.name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $permissionGroup->name) }}" placeholder="{{ __('site.permission_group.name') }}">
                                @error('name')
                                    <div class="form-control-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">{{ __('site.permission.choose_permission') }} <span class="text-danger">*</span></label>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12">
                                        <select  name="permission_id[]"  class="select2 mb-3 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="{{ __('site.permission.choose') }}">
                                            @foreach($permissions as $id => $permissionName)
                                                @php
                                                    $selected = in_array($id, $permissionGroup->permission_id);
                                                    $disabled = in_array($id, $permissionGroupExists) && !$selected;
                                                @endphp
                                                <option value="{{ $id }}" @selected($selected) @disabled($disabled)>{{ $permissionName }}</option>
                                            @endforeach
                                        </select>
                                        @error('permission_id')
                                            <div class="form-control-feedback text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" name="submitter" value="apply" class="btn btn-lg btn-gradient-primary w-100"><i class="far fa-save"></i> {{ __('site.button.save') }}</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="submitter" value="save" class="btn btn-lg btn-gradient-purple w-100"><i class="fas fa-sign-out-alt"></i> {{ __('site.button.save_and_exit') }}</button>
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
    <script src="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
@endpush
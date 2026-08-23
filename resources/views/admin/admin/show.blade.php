@extends('admin.layouts.app')
@section('title')
    {{ $admin->name }}
@endsection
@push('styles')
    <link href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                name="{{ __('site.admin.title') }}"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                                    <span class="d-none d-md-block"><i class="fas fa-user-alt"></i>  {{ __('site.admin.personal_information') }}</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link" data-toggle="tab" href="#change-password" role="tab">
                                    <span class="d-none d-md-block"><i class="fas fa-key"></i>  {{ __('site.admin.reset_password') }}</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link" data-toggle="tab" href="#activities" role="tab">
                                    <span class="d-none d-md-block"><i class="fas fa-history"></i>  {{ __('site.admin.activitity') }}</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content border border-1 mt-3">
                            <div class="tab-pane active p-3" id="profile" role="tabpanel">
                                @include('admin.admin._profile')
                            </div>
                            <div class="tab-pane p-3" id="change-password" role="tabpanel">
                                @include('admin.admin._reset-password')
                            </div>
                            <div class="tab-pane p-3" id="activities" role="tabpanel">
                                @include('admin.admin._activities')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>

@endpush
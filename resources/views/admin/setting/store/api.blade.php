@extends('admin.layouts.app')
@section('title')
    {{ __('site.setting.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.setting.title'), 'url' =>  route('settings.index') ])
        <form id="setting" action="{{ route('settings.store') }}?type={{ request('type') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-2 text-right">
                    <h4>API</h4>
                    <p class="text-gray">{{ __('site.setting.api_settings') }}</p>
                </div>
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <input type="hidden" name="api_enable" value="0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="api_enable" name="api_enable" @checked(isset($settings['api_enable']) && $settings['api_enable'] == 1) value="1">
                                    <label class="custom-control-label" for="api_enable"> API Enable?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" onclick="$('#setting').submit()" class="btn btn-gradient-primary waves-effect waves-light mb-3">
                        <i class="far fa-save mr-2"></i>{{ __('site.button.save_setting') }}
                    </button>
                </div> <!-- end col -->
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
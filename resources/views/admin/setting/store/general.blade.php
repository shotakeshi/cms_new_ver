@extends('admin.layouts.app')
@section('title')
    {{ __('site.setting.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.setting.title'), 'url' => route('settings.index')])
        <form action="{{ route('settings.store') }}?type={{ request('type') }}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf
            <div class="row">
                <div class="col-md-2 text-right">
                    <h4>{{ __('site.setting.general_information') }}</h4>
                    <p class="text-gray">{{ __('site.setting.general_information_note') }}</p>
                </div>
                <div class="col-sm-10">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group upload-group">
                                        <label class="col-form-label">{{ __('site.setting.logo') }}</label>
                                        <input type="file" name="logo" @if(isset($settings['logo'])) data-default-file="{{  asset('storage/'.$settings['logo'])  }}" @endif class="dropify"
                                               data-allowed-file-extensions="jpg jpeg png webp"
                                               data-max-file-size="2M"
                                               data-errors-position="outside"/>
                                        <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group upload-group">
                                        <label class="col-form-label">{{ __('site.setting.favicon') }}</label>
                                        <input type="file" name="favicon" @if(isset($settings['favicon'])) data-default-file="{{  asset('storage/'.$settings['favicon'])  }}" @endif class="dropify"
                                               data-allowed-file-extensions="jpg jpeg png webp"
                                               data-max-file-size="2M"
                                               data-errors-position="outside"/>
                                        <input type="hidden" name="remove_favicon" id="remove_favicon" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="meta_title" class="col-form-label">{{ __('site.setting.admin_email') }} </label>
                                <input type="email" name="admin_email" class="form-control" placeholder="{{ __('site.setting.admin_email') }}" value="{{ $settings['admin_email'] ? $settings['admin_email'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="meta_title" class="col-form-label">{{ __('site.setting.time_zone') }} </label>
                                <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="time_zone">
                                    @foreach($timeZones as $timeZone)
                                        <option @selected(isset($settings['time_zone']) && $settings['time_zone'] === $timeZone) value="{{ $timeZone }}">{{ $timeZone }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="meta_title" class="col-form-label">{{ __('site.setting.site_language') }} </label>
                                <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="locale">
                                    @foreach($globalLanguages as $language)
                                        <option @selected(isset($settings['locale']) && $settings['locale'] === $language->slug) value="{{ $language->slug }}">{{ $language->name }} - {{ $language->slug }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="enable_send_error_reporting_via_email" value="0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="enable-send-error-reporting-via-email" name="enable_send_error_reporting_via_email" @checked(isset($settings['enable_send_error_reporting_via_email']) && $settings['enable_send_error_reporting_via_email'] == 1) value="1">
                                    <label class="custom-control-label" for="enable-send-error-reporting-via-email">{{ __('site.setting.enable_send_error_reporting_via_email') }}</label>
                                </div>
                                <input type="hidden" name="redirect_404_to_homepage" value="0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="redirect-404-to-homepage" name="redirect_404_to_homepage" @checked(isset($settings['redirect_404_to_homepage']) && $settings['redirect_404_to_homepage'] == 1) value="1">
                                    <label class="custom-control-label" for="redirect-404-to-homepage">{{ __('site.setting.redirect_404_to_homepage') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-gradient-primary waves-effect waves-light">
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
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script>
        $(document).ready(function () {
            let drEvent = $('.dropify').dropify();
            drEvent.on('dropify.afterClear', function(event, element) {
                let hiddenInput = $(element.element)
                    .closest('.upload-group')
                    .find('input[type="hidden"]');
                hiddenInput.val(1);
            });
        });
    </script>
@endpush
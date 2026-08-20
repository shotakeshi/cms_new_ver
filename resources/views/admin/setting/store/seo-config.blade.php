@extends('admin.layouts.app')
@section('title')
    {{ __('site.setting.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/codemirror/codemirror.min.css') }}">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}?v=2" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.setting.title'), 'url' => route('settings.index')])
        <form action="{{ route('settings.store') }}?type={{ request('type') }}" id="setting" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-2 text-right">
                    <h4>SEO</h4>
                    <p class="text-gray">SEO Website</p>
                </div>
                <div class="col-sm-10">
                    <div class="card mb-3">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                @foreach($globalLanguages as $key => $language)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-toggle="tab"
                                           href="#seo-config-{{ $language->slug }}" role="tab">{{ $language->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                @foreach($globalLanguages as $key => $language)
                                    <div class="tab-pane {{ $key == 0 ? 'active' : '' }} border p-3 mt-3" id="seo-config-{{ $language->slug }}" role="tabpanel">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('site.setting.title_website') }} </label>
                                            <input type="text" name="title_website[{{ $language->slug }}]" class="form-control" placeholder="{{ __('site.setting.title_website') }}" value="{{ !empty($settings['title_website']) && $settings['title_website'][ $language->slug ] ? $settings['title_website'][ $language->slug ] : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title" class="col-form-label">{{ __('site.page.meta_title') }} </label>
                                            <input type="text" name="meta_title[{{ $language->slug }}]" class="form-control meta_title" maxlength="60"
                                                   value="{{ !empty($settings['meta_title']) && $settings['meta_title'][ $language->slug ] ? $settings['meta_title'][ $language->slug ] : '' }}" placeholder="{{ __('site.page.meta_title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description" class="col-form-label">{{ __('site.page.meta_description') }} </label>
                                            <textarea name="meta_description[{{ $language->slug }}]" class="form-control meta_description" maxlength="150" placeholder="{{ __('site.page.meta_description') }}" rows="5">{{ !empty($settings['meta_description']) && $settings['meta_description'][ $language->slug ] ? $settings['meta_description'][ $language->slug ] : '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keywords" class="col-form-label">{{ __('site.page.meta_keywords') }}</label>
                                            <div class="u-tagsinput">
                                                <input name="meta_keywords[{{ $language->slug }}]" class="form-control w-100" type="text" data-role="tagsinput" value="{{ !empty($settings['meta_keywords']) && $settings['meta_keywords'][ $language->slug ] ? $settings['meta_keywords'][ $language->slug ] : '' }}" placeholder="{{ __('site.page.meta_keywords') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="$('#setting').submit()" class="btn btn-gradient-primary waves-effect waves-light mb-3">
                        <i class="far fa-save mr-2"></i>{{ __('site.button.save_setting') }}
                    </button>
                </div> <!-- end col -->
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script>
        $('.meta_title, .meta_description').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger",
            separator: ' {{ __('seo.separator') }} ',
            preText: '{{ __('seo.pre_text') }} ',
            postText: ' {{ __('seo.post_text') }}',
            validate: true
        });
    </script>
@endpush
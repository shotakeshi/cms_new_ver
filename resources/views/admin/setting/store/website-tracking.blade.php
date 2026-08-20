@extends('admin.layouts.app')
@section('title')
    {{ __('site.setting.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/codemirror/codemirror.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.setting.title'), 'url' => route('settings.index')])
        <form action="{{ route('settings.store') }}?type={{ request('type') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-2 text-right">
                    <h4>{{ __('site.setting.website_tracking') }}</h4>
                    <p class="text-gray">{{ __('site.setting.website_tracking_note') }}</p>
                </div>
                <div class="col-sm-10">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="form-check-inline mr-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="google_tag_id" name="google_tag_manager_type" class="custom-control-input" value="id" @checked(isset($settings['google_tag_manager_type']) && $settings['google_tag_manager_type'] == "id")>
                                    <label class="custom-control-label" for="google_tag_id">{{ __('site.setting.google_tag_id') }}</label>
                                </div>
                            </div>
                            <div class="form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="google_tag_code" name="google_tag_manager_type" class="custom-control-input" value="code" @checked(isset($settings['google_tag_manager_type']) && $settings['google_tag_manager_type'] == "code")>
                                    <label class="custom-control-label" for="google_tag_code">{{ __('site.setting.google_tag_code') }}</label>
                                </div>
                            </div>
                            <div id="google_tag_id_group">
                                <div class="form-group mb-3">
                                    <label class="col-form-label">{{ __('site.setting.google_tag_manager_id') }}</label>
                                    <input type="text" name="google_tag_manager_id" class="form-control" placeholder="Example: G-123ABC4567" value="{{ $settings['google_tag_manager_id'] ?? '' }}">
                                </div>
                                <a href="{{ config('utilities.google_tag_url') }}" target="_blank">
                                    <span class="text-primary">{{ config('utilities.google_tag_url') }}</span>
                                </a>
                            </div>
                            <div id="google_tag_code_group">
                                <div class="form-group mb-3">
                                    <label class="col-form-label">{{ __('site.setting.google_tag_manager_code') }}</label>
                                    <textarea name="google_tag_manager_code" id="editor" class="form-control" rows="10">{{ $settings['google_tag_manager_code'] ?? '' }}</textarea>
                                </div>
                                <a href="{{ config('utilities.google_tag_platform_url') }}" target="_blank">
                                    <span class="text-primary">{{ config('utilities.google_tag_platform_url') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary waves-effect waves-light mb-3">
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
    <script src="{{ asset('administrator/phoenix/plugins/codemirror/codemirror.min.js') }}"></script>
    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            mode: "javascript",
            theme: "dracula",
            lineNumbers: true,
            lineWrapping: true,
            matchBrackets: true,
            autoCloseBrackets: true,
            tabSize: 4,
            indentWithTabs: true,
            styleActiveLine: true,
            gutters: ["CodeMirror-linenumbers", "breakpoints"]
        });

        // Thêm sự kiện click vào gutter để đánh dấu breakpoint
        editor.on("gutterClick", function(cm, n) {
            var info = cm.lineInfo(n);
            cm.setGutterMarker(n, "breakpoints", info.gutterMarkers ? null : makeMarker());
        });

        function makeMarker() {
            var marker = document.createElement("div");
            marker.style.color = "#ff0000";
            marker.innerHTML = "●";
            return marker;
        }

        $( document ).ready(function() {
           function toggleFieldsRadio() {
               const tagIdChecked = $('#google_tag_id').is(':checked');
               const idGroup = $('#google_tag_id_group');
               const codeGroup = $('#google_tag_code_group');

               if(tagIdChecked) {
                    idGroup.show();
                    codeGroup.hide();
               } else {
                    idGroup.hide();
                    codeGroup.show();
               }
           }
           $("input[name='google_tag_manager_type']").on('change', toggleFieldsRadio);

           toggleFieldsRadio();
       })
    </script>
@endpush
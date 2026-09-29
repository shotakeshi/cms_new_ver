@extends('admin.layouts.app')
@section('title')
    {{ __('site.widget.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.widget.title_create')"
                :url="route('widgets.create')"
        />
        <form id="widget" action="{{ route('widgets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            {{ __('site.widget.main_information') }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-admin::forms.input
                                            name="name"
                                            label="{{ __('site.widget.name') }}"
                                            placeholder="{{ __('site.widget.name') }}"
                                            required
                                            onkeyup="generateSlug(this)"
                                    />
                                </div>
                                <div class="col-lg-4">
                                    <x-admin::forms.input
                                            name="slug"
                                            label="{{ __('site.widget.code') }}"
                                            placeholder="{{ __('site.widget.code') }}"
                                            required
                                    />
                                </div>
                                <div class="col-lg-2">
                                    <x-admin::forms.radio-enums
                                            name="status"
                                            label="{{ __('site.admin.status') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                            :selected="\App\Enums\DefaultStatus::ACTIVE->value"
                                    />
                                </div>
                                <div class="col-lg-2">
                                    <x-admin::forms.input
                                            name="type"
                                            label="{{ __('site.widget.type') }}"
                                            placeholder="{{ __('site.widget.type') }}"
                                            :value="request('type')"
                                            readonly
                                            required
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.widget.official_information') }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
                                        @foreach($globalLanguages as $language)
                                            <li class="nav-item mr-3">
                                                <a class="btn btn-outline-danger" id="widget_tab" data-toggle="pill" href="#{{ $language->slug }}">
                                                    {{ $language->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-lg-12">
                                    <div class="tab-content detail-list" id="pills-tabContent">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @foreach($globalLanguages as $language)
                                                    <div class="tab-pane fade" id="{{ $language->slug }}">
                                                        @include('admin.widget.type.' . request('type'),
                                                                    [ 'languageSlug' => $language->slug ])
                                                    </div><!--end general detail-->
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('administrator/assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        function generateSlug(input){
            const slug = document.getElementById("slug");
            slug.value = createSlug(input.value);
        }

        function createSlug(string) {
            return string
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/đ/g, "d")
                .replace(/Đ/g, "D")
                .replace(/[^a-zA-Z0-9\s-]/g, "")
                .trim()
                .replace(/\s+/g, "-")
                .replace(/-+/g, "-")
                .toLowerCase();
        }
    </script>
@endpush
@extends('admin.layouts.app')
@section('title')
    {{ __('site.language.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.language.title')"
        />
        <div class="row">
            <div class="col-lg-7">
                @include('admin.language._table')
            </div>
            <div class="col-lg-5">
                <form action="{{ route('languages.store') }}" method="POST">
                    <div class="card">
                        <div class="card-header">
                            {{ __('site.language.title_create') }}
                        </div>
                        <div class="card-body">
                            @csrf
                            <x-admin::forms.input
                                    name="name"
                                    label="{{ __('site.language.name') }}"
                                    placeholder="{{ __('site.language.name') }}"
                                    required
                            />
                            <x-admin::forms.select
                                    name="name"
                                    label="{{ __('site.language.name') }}"
                                    :options="\App\NativeCountry\CountryNames::options()"
                                    option-value="value"
                                    option-label="label"
                                    :select2="true"
                                    required
                            />
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-admin::forms.input
                                            name="code"
                                            label="{{ __('site.language.code') }}"
                                            placeholder="{{ __('site.language.code') }}"
                                    />
                                </div>
                                <div class="col-lg-6">
                                    <x-admin::forms.radio-enums
                                            name="status"
                                            label="{{ __('site.admin.status') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                            :selected="\App\Enums\DefaultStatus::ACTIVE->value"
                                    />
                                </div>
                            </div>
                            <x-admin::forms.actions
                                    show-reset
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
@endpush
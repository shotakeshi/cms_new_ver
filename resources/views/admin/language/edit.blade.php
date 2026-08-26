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
                <div class="card mb-3">
                    <div class="card-header">
                        {{ __('site.language.title_edit') }}
                    </div>
                    <div class="card-body">
                        <form class="" action="{{ route('languages.update', $language) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-admin::forms.input
                                    name="name"
                                    label="{{ __('site.language.name') }}"
                                    placeholder="{{ __('site.language.name') }}"
                                    :value="$language->name"
                                    required
                            />
                            <x-admin::forms.select
                                    name="slug"
                                    label="{{ __('site.language.slug') }}"
                                    :options="\App\NativeCountry\CountryNames::options()"
                                    option-value="value"
                                    option-label="label"
                                    :select2="true"
                                    :selected="$language->slug"
                                    required
                            />
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-admin::forms.input
                                            name="code"
                                            label="{{ __('site.language.code') }}"
                                            placeholder="{{ __('site.language.code') }}"
                                            :value="$language->code"
                                    />
                                </div>
                                <div class="col-lg-6">
                                    <x-admin::forms.radio-enums
                                            name="status"
                                            label="{{ __('site.admin.status') }}"
                                            :options="\App\Enums\DefaultStatus::options()"
                                            :selected="$language->status->value"
                                    />
                                </div>
                            </div>
                            <x-admin::forms.actions
                            />
                        </form>
                    </div>
                </div>
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
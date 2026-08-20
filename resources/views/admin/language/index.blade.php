@extends('admin.layouts.app')
@section('title')
    {{ __('site.language.title') }}
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.language.title'), 'url' => route('settings.index')])
        <div class="row">
            <div class="col-lg-7">
                @include('admin.language._table')
            </div>
            <div class="col-lg-5">
                <form class="" action="{{ route('languages.store') }}" method="POST">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('site.language.title_create') }}</h4>
                            <p class="text-muted mb-3">{{ __('site.language.note_enter_information') }}</p>
                            @csrf
                            <div class="form-group">
                                <label>{{ __('site.language.name') }}</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="{{ __('site.language.name') }}"/>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('site.language.slug') }}</label>
                                <select class="select2 form-control custom-select" name="slug" style="width: 100%; height:36px;">
                                    @foreach(\App\NativeCountry\CountryNames::getName() as $code => $name)
                                        <option value="{{ $code }}">[{{ $code }}] | {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('site.language.code') }}</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="{{ __('site.language.code') }}"/>
                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('site.language.status') }}</label>
                                <select class="form-control" name="status">
                                    @foreach(\App\Enums\DefaultStatus::cases() as $status)
                                        <option value="{{ $status->value }}" {{ old('status') == $status->value  ? 'selected' : '' }}>{{ \App\Enums\DefaultStatus::from($status->value)->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-gradient-primary px-5 w-100">
                                <i class="fa fa-plus"></i> {{ __('site.button.create') }}
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="reset" class="btn btn-gradient-danger px-5 w-100">
                                <i class="ti-close"></i> {{ __('site.button.cancel') }}
                            </button>
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
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
@endpush
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
                            @include('admin.widget.type.' . request('type'),['globalLanguages' => $globalLanguages])
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
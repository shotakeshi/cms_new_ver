@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.department.title_create')"
                :url="route('departments.index')"
        />
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="card mb-3">
                        <div class="card-header">
                            {{ __('site.department.title_create') }}
                        </div>
                        <div class="card-body">
                            <x-admin::forms.input
                                name="name"
                                label="{{ __('site.department.name') }}"
                                placeholder="{{ __('site.department.name') }}"
                                required
                            />
                            <x-admin::forms.textarea
                                name="description"
                                label="{{ __('site.department.description') }}"
                                placeholder="{{ __('site.department.description') }}"
                                rows="5"
                            />
                            <x-admin::forms.actions
                                :back-url="route('departments.index')"
                                show-reset
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
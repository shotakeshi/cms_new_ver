@extends('admin.layouts.app')
@section('title')
    {{ __('site.admin.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                name="{{ __('site.admin.title') }}"
        />
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card m-b-30">
                    <div class="card-header">
                        {{ __('site.button.change_password') }}
                    </div>
                    <div class="card-body">
                        <form id="form-change-password" action="{{ route('admin.update-password') }}" method="POST">
                            @csrf
                            <x-admin::forms.input
                                    name="current_password"
                                    type="password"
                                    label="{{ __('site.admin.current_password') }}"
                                    placeholder="{{ __('site.admin.current_password') }}"
                                    required
                            />
                            <x-admin::forms.input
                                    name="password"
                                    type="password"
                                    label="{{ __('site.admin.password') }}"
                                    placeholder="{{ __('site.admin.password') }}"
                                    required
                            />
                            <x-admin::forms.input
                                    name="password_confirmation"
                                    type="password"
                                    label="{{ __('site.admin.password_confirmation') }}"
                                    placeholder="{{ __('site.admin.password_confirmation') }}"
                                    required
                            />
                            <div class="text-right">
                                <a href="{{ route('admins.index') }}" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-arrow-left"></i>
                                    {{ __('site.button.back') }}
                                </a>
                                <button type="submit" id="btn-change-password" class="btn btn-sm btn-outline-primary">
                                    <i class="far fa-save"></i>
                                    {{ __('site.button.change_password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
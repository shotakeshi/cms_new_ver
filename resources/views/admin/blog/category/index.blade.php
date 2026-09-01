@extends('admin.layouts.app')
@section('title')
    {{ __('site.blog.categories.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.blog.categories.title')"
        />
        <div class="row">
            <div class="col-4">
                @if (isset($isEditMode))
                    <div class="alert icon-custom-alert alert-outline-primary alert-primary-shadow" role="alert">
                        <i class="fas fa-exclamation alert-icon font-18"></i>
                        <div class="alert-text">
                            {!!  __('site.page.note_update', ['locale' => $languageVersionName]) !!}
                        </div>
                    </div>
                @endif
                @include('admin.blog.category._form')
            </div>
            <div class="col-8">
                <div class="card m-b-30">
                    <div class="card-header">
                        {{ __('site.blog.categories.list') }}
                    </div>
                    <div class="card-body">
                        @include('admin.blog.category._table')
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
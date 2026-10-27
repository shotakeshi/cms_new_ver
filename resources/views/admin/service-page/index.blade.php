@extends('admin.layouts.app')
@section('title')
    {{ __('site.service-pages.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.page.title')"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        @include('admin.service-page._filters')
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        @include('admin.service-page._table')
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
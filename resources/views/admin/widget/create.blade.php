@extends('admin.layouts.app')
@section('title')
    {{ __('site.widget.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.widget.title_create')"
                :url="route('widgets.index')"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        @use('App\Enums\WidgetType')
                        <div class="row">
                            @foreach (WidgetType::cases() as $type)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <a href="{{ route('widgets.create', ['type' => $type->value]) }}" class="btn btn-outline-primary w-100 pt-5 pb-5 mb-4" >
                                        <div class="text-center">
                                            <h1>
                                                <i class="{{ $type->icon() }}"></i>
                                            </h1>
                                            <div>
                                                <h5>
                                                    {{ $type->label() }}
                                                </h5>
                                                <div class="text-muted mt-1 font-12">
                                                    {{ $type->description() }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
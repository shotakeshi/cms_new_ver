@extends('admin.layouts.app')
@section('title')
    {{ __('site.widget.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.widget.title')"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between align-items-center mt-2 text-muted">
                                    {{ __('site.widget.total') }}: {{ $widgets->total() }} Widget
                                </div>
                            </div>
                            <div class="col-lg-6 text-right">
                                <x-admin::page-actions
                                        :create-url="route('widgets.create')"
                                        :reload-url="route('widgets.index')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th width="60" class="text-center">#</th>
                                    <th>{{ __('site.widget.name') }}</th>
                                    <th>{{ __('site.widget.code') }}</th>
                                    <th width="140">{{ __('site.widget.type') }}</th>
                                    <th width="140">{{ __('site.widget.status') }}</th>
                                    <th width="250" class="text-center"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($widgets as $widget)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $widget->name }}<br>
                                        </td>
                                        <td>{{ $widget->slug }}</td>
                                        <td>
                                            <span class="badge badge-soft-primary p-2" style="width: 100px">
                                                {{ $widget->type }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ((int) $widget->status === 1)
                                                <span class="badge badge-soft-success p-2" style="width: 100px">
                                                    {{ __('site.status.active') }}
                                                </span>
                                            @else
                                                <span class="badge badge-soft-secondary p-2" style="width: 100px">
                                                    {{ __('site.status.inactive') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="actions">
                                                <a class="btn btn-outline-warning"
                                                   href="{{ route('widgets.edit', $widget) }}?type={{ $widget->type }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if(auth()->user()->rootAdmin)
                                                    @if((int) $widget->status_lock === 1)
                                                        <a class="btn btn-outline-primary" title="lock"
                                                           href="{{ route('widgets.update_status_lock', $widget->id) }}">
                                                            <i class="fa fa-lock"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-outline-primary" title="lock"
                                                           href="{{ route('widgets.update_status_lock', $widget->id) }}">
                                                            <i class="fa fa-unlock-alt"></i>
                                                        </a>
                                                        <x-admin::buttons.delete-button
                                                                :action="route('widgets.destroy',$widget)"
                                                        />
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="text-center text-muted py-4">
                                            {{ __('site.widget.no_widget') }}
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
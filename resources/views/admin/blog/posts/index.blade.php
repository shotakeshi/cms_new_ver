@extends('admin.layouts.app')
@section('title')
    {{ __('site.blog.posts.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        <x-admin::page-title
                :name="__('site.blog.posts.title')"
        />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('site.blog.posts.filter') }}
                    </div>
                    <div class="card-body">
                        @include('admin.blog.posts._filters')
                    </div>
                </div>
{{--                <div class="card m-b-30">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-sm-7 mt-2">--}}
{{--                                <a class="border-right border-gray pr-2 mr-1" href="{{ route('pages.index') }}">{{ __('site.filter.all') }} ({{ collect($statusCounts)->sum() }})</a>--}}
{{--                                @foreach(\App\Enums\DefaultStatus::cases() as $status)--}}
{{--                                    <a class="border-right border-gray pr-1 mr-2" href="{{ route('pages.index') }}?status={{ $status->value }}">--}}
{{--                                        {{ \App\Enums\DefaultStatus::from($status->value)->getName() }} ({{ $statusCounts[$status->value] ?? 0 }})--}}
{{--                                    </a>--}}
{{--                                @endforeach--}}
{{--                                <a href="{{ route('pages.trash') }}">{{ __('site.filter.trash') }} ({{ $totalTrashedCount }})</a>--}}
{{--                            </div>--}}
{{--                            <div class="col-5 text-right">--}}
{{--                                <a class="btn btn-gradient-primary waves-effect waves-light px-5" href="{{ route('pages.create') }}">--}}
{{--                                    <i class="fa fa-plus"></i> {{ __('site.button.create') }}--}}
{{--                                </a>--}}
{{--                                <a class="btn btn btn-gradient-dark waves-effect waves-light px-5" href="{{ route('pages.index') }}">--}}
{{--                                    <i class="fas fa-redo"></i> {{ __('site.button.reload') }}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-sm-5 mt-2">--}}
{{--                                <form class="form-inline">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <input class="form-control" name="name" value="{{ request('name') }}">--}}
{{--                                        <input type="submit" class="ml-2 btn btn-outline-primary" value="{{ __('site.page.search_pages') }}">--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table table-striped mb-0">--}}
{{--                                <thead class="thead-light">--}}
{{--                                    <tr>--}}
{{--                                        <th class="text-center" style="width: 50px">#</th>--}}
{{--                                        <th style="width: 500px">{{ __('site.page.name') }}</th>--}}
{{--                                        <th class="text-center" style="width: 150px">{{ __('site.page.status') }}</th>--}}
{{--                                        <th class="text-center" style="width: 150px">{{ __('site.page.status_comment') }}</th>--}}
{{--                                        <th class="text-center" style="width: 150px">{{ __('site.button.author') }}</th>--}}
{{--                                        <th class="text-center" style="width: 100px">--}}
{{--                                            @foreach($globalLanguages as $language)--}}
{{--                                                <img alt="{{ $language->name }}" style="max-width: 20px" src="{{ asset('flags/'.$language->slug.'.png') }}">--}}
{{--                                            @endforeach--}}
{{--                                        </th>--}}
{{--                                        <th class="text-center" style="width: 300px">{{ __('site.button.date') }}</th>--}}
{{--                                    </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                    @foreach($pages as $page)--}}
{{--                                        <tr class="hover-target" id="row-{{ $page->id}}" >--}}
{{--                                            <td class="text-center">{{ $loop->iteration }}</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="mb-1">--}}
{{--                                                    @if(!$page->trashed())--}}
{{--                                                        <a href="{{ route('pages.edit', $page) }}?ref_lang={{ app()->getLocale() }}">--}}
{{--                                                            <span class="font-14 text-primary">{{ $pageContents[$page->id][$appLocale]['name'] ?? ''}}</span>--}}
{{--                                                        </a>--}}
{{--                                                    @else--}}
{{--                                                       <span class="font-14 text-gray font-italic">{{ $pageContents[$page->id][$appLocale]['name'] ?? ''}}</span>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                                <div style="height: 22px">--}}
{{--                                                    <div class="row-action hidden-div">--}}
{{--                                                        @if(isset($pageTrash) || $page->trashed())--}}
{{--                                                            <a class="border-right text-primary border-gray pr-2 mr-1" href="{{ route('pages.restore', $page) }}">{{ __('site.button.restore') }}</a>--}}
{{--                                                            <a class="text-danger border-gray pr-2 mr-1" href="javascript:void(0)" onclick="event.preventDefault(); confirmDelete( {{ $page->id }}, '{{ route('pages.force-delete', $page) }}' )">{{ __('site.button.delete_permanently') }}</a>--}}
{{--                                                        @else--}}
{{--                                                            <a class="border-right text-primary border-gray pr-2 mr-1" href="{{ route('pages.edit', $page) }}">{{ __('site.button.edit') }}</a>--}}
{{--                                                            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $page->id }}').submit();" class="border-right text-danger border-gray pr-2 mr-1" >{{ __('site.button.trash') }}</a>--}}
{{--                                                            <a href="{{ route('pages.show', $page) }}">{{ __('site.button.preview') }}</a>--}}
{{--                                                            <form id="delete-form-{{ $page->id }}" action="{{ route('pages.destroy', $page) }}" method="POST">--}}
{{--                                                                @csrf--}}
{{--                                                                @method('DELETE')--}}
{{--                                                            </form>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                <span class="{{ $page->status_class }} p-1" style="width: 100px">{{ $page->status_name  }}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                <span class="{{ $page->status_comment_class }} p-1" style="width: 100px">{{ $page->status_comment_name  }}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                <span style="width: 100px">{{ $page->admin->name ?? '' }}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                @if(!$page->trashed())--}}
{{--                                                    @foreach($globalLanguages as $language)--}}
{{--                                                        @if(!empty($pageContents[$page->id][$language->slug]))--}}
{{--                                                            <a href="{{ route('pages.edit', $page) }}?ref_lang={{ $language->slug }}">--}}
{{--                                                                <i class="font-20 mdi mdi-square-edit-outline text-success"></i>--}}
{{--                                                            </a>--}}
{{--                                                        @else--}}
{{--                                                            <a href="{{ route('pages.edit', $page) }}?ref_lang={{ $language->slug }}">--}}
{{--                                                                <i class="font-20 mdi mdi-shape-square-plus text-primary"></i>--}}
{{--                                                            </a>--}}
{{--                                                        @endif--}}
{{--                                                    @endforeach--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                            <td class="text-right">--}}
{{--                                                <span class="text-gray font-italic">{{ __('site.page.created_at') }}: </span>--}}
{{--                                                <span class="text-primary">{{ $page->created_at }}</span><br/>--}}
{{--                                                <span class="text-gray font-italic">{{ __('site.button.last_modified') }}: </span>--}}
{{--                                                <span class="text-beanred">{{ $page->updated_at }}</span>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div> <!-- end col -->
        </div>
    </div>
@endsection
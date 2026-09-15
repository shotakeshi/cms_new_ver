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
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px">#</th>
                                        <th style="width: 500px">{{ __('site.page.name') }}</th>
                                        <th class="text-center" style="width: 150px">{{ __('site.page.status') }}</th>
                                        <th class="text-center" style="width: 150px">{{ __('site.page.status_comment') }}</th>
                                        <th class="text-center" style="width: 150px">{{ __('site.button.author') }}</th>
                                        <th class="text-center" style="width: 100px">
                                            @foreach($globalLanguages as $language)
                                                <img alt="{{ $language->name }}" style="max-width: 20px" src="{{ asset('flags/'.$language->slug.'.png') }}">
                                            @endforeach
                                        </th>
                                        <th class="text-center" style="width: 300px">{{ __('site.button.date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogPosts as $blogPost)
                                        <tr class="hover-target" id="row-{{ $blogPost->id}}" >
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="mb-1">
                                                    @if(!$blogPost->trashed())
                                                        <a href="{{ route('blog-posts.edit', $blogPost) }}?ref_lang={{ app()->getLocale() }}">
                                                            <span class="font-14 text-primary">{{ $blogPostContents[$blogPost->id][$appLocale]['name'] ?? ''}}</span><br/>
                                                            <span class="text-muted font-italic">{{ $blogPostContents[$blogPost->id][$appLocale]['excerpt'] ?? ''}}</span>
                                                        </a>
                                                    @else
                                                        <span class="font-14 text-gray font-italic">{{ $blogPostContents[$blogPost->id][$appLocale]['name'] ?? ''}}</span><br/>
                                                        <span class="text-muted font-italic">{{ $blogPostContents[$blogPost->id][$appLocale]['excerpt'] ?? ''}}</span>
                                                    @endif
                                                </div>
                                                <div style="height: 22px">
                                                    <div class="row-action hidden-div">
                                                        @if(isset($blogPostTrash) || $blogPost->trashed())
                                                            <a class="border-right text-primary border-gray pr-2 mr-1" href="{{ route('blog-posts.restore', $blogPost) }}">{{ __('site.button.restore') }}</a>
                                                            <x-admin::buttons.delete-button
                                                                    :action="route('blog-posts.force-delete', $blogPost)"
                                                                    asText
                                                                    :title="__('site.button.delete_permanently')"
                                                            />
                                                        @else
                                                            <a class="border-right text-primary border-gray pr-2 mr-1" href="{{ route('blog-posts.edit', $blogPost) }}">{{ __('site.button.edit') }}</a>
                                                            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $blogPost->id }}').submit();" class="border-right text-danger border-gray pr-2 mr-1" >{{ __('site.button.trash') }}</a>
                                                            <a href="{{ route('blog-posts.show', $blogPost) }}">{{ __('site.button.preview') }}</a>
                                                            <form id="delete-form-{{ $blogPost->id }}" action="{{ route('blog-posts.destroy', $blogPost) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $blogPost->status_class }} p-1" style="width: 100px">{{ $blogPost->status_name  }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $blogPost->status_comment_class }} p-1" style="width: 100px">{{ $blogPost->status_comment_name  }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span style="width: 100px">{{ $blogPost->admin->name ?? '' }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if(!$blogPost->trashed())
                                                    @foreach($globalLanguages as $language)
                                                        @if(!empty($blogPostContents[$blogPost->id][$language->slug]))
                                                            <a href="{{ route('blog-posts.edit', $blogPost) }}?ref_lang={{ $language->slug }}">
                                                                <i class="font-20 mdi mdi-square-edit-outline text-success"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('blog-posts.edit', $blogPost) }}?ref_lang={{ $language->slug }}">
                                                                <i class="font-20 mdi mdi-shape-square-plus text-primary"></i>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <span class="text-gray font-italic">{{ __('site.page.created_at') }}: </span>
                                                <span class="text-primary">{{ $blogPost->created_at }}</span><br/>
                                                <span class="text-gray font-italic">{{ __('site.button.last_modified') }}: </span>
                                                <span class="text-beanred">{{ $blogPost->updated_at }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('administrator/phoenix/plugins/select2/select2.min.css') }}">
@endpush
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
@endpush
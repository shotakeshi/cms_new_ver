@extends('admin.layouts.app')
@section('title')
    {{ __('site.blog.categories.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.blog.categories.title')])
        <div class="row">
            <div class="col-4">
                @include('admin.blog.category._create')
            </div>
            <div class="col-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        @include('admin.blog.category._filters')
                        @include('admin.blog.category._table')
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
    @include('admin.partials._delete_modal')
@endsection
@push('scripts')
    <script>
        $(document).on('click', '.btn-delete', function () {
            let url = $(this).data('url');
            let name = $(this).data('name');
            $('#deleteForm').attr('action', url);
            $('#deleteMessage').text(
                "{{ __('site.notification.confirm_delete') }}: " + name + " ?"
            );
        });
    </script>
@endpush
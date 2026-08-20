@extends('admin.layouts.app')
@section('title')
    {{ __('site.page.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.page.title')])
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        @include('admin.page._filters')
                        @include('admin.page._table')
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        @include('admin.partials._delete_modal')
    </div>
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
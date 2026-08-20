@extends('admin.layouts.app')
@section('title')
    {{ __('site.page.title') }}
@endsection
@section('content')
    <div class="container-fluid">
    @include('admin.layouts.partials.page-title-box', ['name' => __('site.blog.create_category_title')])
        <form id="page" action="{{ route('blog-categories.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title"><span class="text-danger">{{ __('site.blog.general_information') }}</h4>
                            <p class="text-muted mb-3">{{ __('site.blog.general_information_note') }}</p>
                            <div class="form-group">
                                <label for="name">{{ __('site.page.name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       onkeyup="generateSlug(this)"
                                       value="{{ old('name') }}" placeholder="{{ __('site.page.name') }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">{{ __('site.page.slug') }} <span class="text-danger">*</span></label>
                                <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug') }}" placeholder="{{ __('site.page.slug') }}">
                                @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('site.page.description') }}</label>
                                <textarea class="form-control" id="description" name="description" placeholder="{{ __('site.page.description') }}" rows="5">{{ old('description') }}</textarea>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('site.page.config') }}</h4>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="name" class="col-form-label">{{ __('site.page.status') }}</label>
                                        </div>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            @foreach(\App\Enums\DefaultStatus::cases() as $status)
                                                <label class="btn btn-outline-beanred active">
                                                    <input type="radio" value="{{ $status->value }}" name="status" @checked($status->value == \App\Enums\DefaultStatus::ACTIVE->value)> {{ \App\Enums\DefaultStatus::from($status->value)->getName() }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" name="submitter" onclick="$('#page').submit()" value="apply" class="btn btn-lg btn-gradient-primary w-100"><i class="far fa-save"></i> {{ __('site.button.save') }}</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" name="submitter" onclick="$('#page').submit()" value="save" class="btn btn-lg btn-gradient-purple w-100"><i class="fas fa-sign-out-alt"></i> {{ __('site.button.save_and_exit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script>
        function generateSlug(input){
            const slug = document.getElementById("slug");
            slug.value = createSlug(input.value);
        }

        function createSlug(string) {
            return string
                .toString()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-zA-Z0-9\s-]/g, "")
                .trim()
                .replace(/\s+/g, "-")
                .toLowerCase();
        }
    </script>
@endpush
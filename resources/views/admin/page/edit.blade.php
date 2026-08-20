@extends('admin.layouts.app')
@section('title')
    {{ __('site.page.title') }}
@endsection
@push('styles')
    <link href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('administrator/phoenix/plugins/timepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}?v=1" rel="stylesheet">
    <link href="{{ asset('administrator/phoenix/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.page.update_title'), 'url' =>  route('pages.index')])
        <form id="page" action="{{ route('pages.update', $page) }}?ref_lang={{ $refLang }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert icon-custom-alert alert-outline-primary alert-primary-shadow" role="alert">
                                <i class="fas fa-exclamation alert-icon font-18"></i>
                                <div class="alert-text">
                                    {!!  __('site.page.note_update', ['locale' => $languageVersionName]) !!}
                                </div>
                            </div>
                            <input type="hidden" name="language_code" readonly value="{{ $refLang }}">
                            <div class="form-group">
                                <label for="name">{{ __('site.page.name') }} <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $pageContent->name ?? '') }}" placeholder="{{ __('site.page.name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">{{ __('site.page.slug') }} <span class="text-danger">*</span></label>
                                <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $page->slug ?? '') }}" placeholder="{{ __('site.page.slug') }}">
                                @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('site.page.description') }}</label>
                                <textarea class="form-control" id="description" name="description" placeholder="{{ __('site.page.description') }}" rows="5">{{ old('description', $pageContent->description ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="content">{{ __('site.page.content') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control ckeditor @error('content') is-invalid @enderror"
                                          name="content" placeholder="{{ __('site.page.content') }}" rows="5">{{ old('content', $pageContent->content ?? '') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <hr>
                            {{--  SEO --}}
                            <h4 class="mt-0 header-title">{{ __('site.page.seo') }}</h4>
                            <p class="text-muted mb-3">{{ __('site.page.seo_config') }}</p>
                            <div class="form-group">
                                <label for="meta_title" class="col-form-label">{{ __('site.page.meta_title') }} </label>
                                @include('admin.layouts.seo.meta_title')
                                <input type="text" id="meta_title" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" maxlength="60"
                                       value="{{ old('meta_title', $pageContent->meta_title ?? '') }}" placeholder="{{ __('site.page.meta_title') }}">
                                @error('meta_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="meta_description" class="col-form-label">{{ __('site.page.meta_description') }} </label>
                                @include('admin.layouts.seo.meta_description')
                                <textarea id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" maxlength="150" placeholder="{{ __('site.page.meta_description') }}" rows="5">{{ old('meta_description', $pageContent->meta_description ?? '') }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords" class="col-form-label">{{ __('site.page.meta_keywords') }}</label>
                                @include('admin.layouts.seo.meta_keyword')
                                <div class="u-tagsinput">
                                    <input name="meta_keywords" class="form-control w-100 @error('meta_keywords') is-invalid @enderror" type="text" data-role="tagsinput" value="{{ old('meta_keywords', $pageContent->meta_keywords ?? '') }}" placeholder="{{ __('site.page.meta_keywords') }}">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('site.page.another_lang') }}</h4>
                            @foreach($globalLanguages as $language)
                                @if($language->slug != $refLang)
                                    <div>
                                        <a href="{{ route('pages.edit', $page) }}?ref_lang={{ $language->slug }}">
                                            <img alt="{{ $language->name }}" style="max-width: 20px" src="{{ asset('flags/'.$language->slug.'.png') }}">
                                            <span>{{ $language->name }}</span>
                                            <i class="font-16 far fa-edit text-primary pt-2"></i>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                            <hr/>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ __('site.page.avatar') }}</label>
                                        <input type="file" name="image" @if(isset($pageContent->image))
                                            data-default-file="{{  asset('storage/'.$pageContent->image)  }}" @endif class="dropify @error('image') is-invalid @enderror" />
                                        <input type="hidden" name="remove_image" id="remove_image" value="0" >
                                        @error('file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ __('site.tags') }}</label>
                                        <div class="u-tagsinput">
                                            <input name="tags" class="form-control w-100" type="text" data-role="tagsinput" value="{{ old('tags', $tagNames) }}" placeholder="{{ __('site.tags') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ __('site.page.published_at') }}</label>
                                        <input type="text" id="date-publish-at" name="published_at"
                                               class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', $page->published_at) }}" placeholder="dd/mm/yyyy - hh:mm">
                                        @error('published_at')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="name" class="col-form-label">{{ __('site.page.status') }}</label>
                                        </div>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            @foreach(\App\Enums\DefaultStatus::cases() as $status)
                                                <label class="btn btn-outline-beanred active">
                                                    <input type="radio" value="{{ $status->value }}" name="status" @checked($status->value == $page->status)> {{ \App\Enums\DefaultStatus::from($status->value)->getName() }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="name" class="col-form-label">{{ __('site.page.status_comment') }}</label>
                                        </div>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            @foreach(\App\Enums\DefaultStatus::cases() as $status)
                                                <label class="btn btn-outline-beanred active">
                                                    <input type="radio" value="{{ $status->value }}" name="status_comment" @checked($status->value == $page->status_comment)> {{ \App\Enums\DefaultStatus::from($status->value)->getName() }}
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
                            <button type="submit" onclick="$('#page').submit()" class="btn btn-lg btn-gradient-primary w-100"><i class="far fa-save"></i> {{ __('site.button.save') }}</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" onclick="$('#page').submit()" name="submitter" value="save_and_exit" class="btn btn-lg btn-gradient-purple w-100"><i class="fas fa-sign-out-alt"></i> {{ __('site.button.save_and_exit') }}</button>
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
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('administrator/assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        $('.dropify').dropify().on('dropify.afterClear', function(event, element) {
            document.getElementById('remove_image').value = 1;
        });

        $('input#meta_title, textarea#meta_description').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger",
            separator: ' {{ __('seo.separator') }} ',
            preText: '{{ __('seo.pre_text') }} ',
            postText: ' {{ __('seo.post_text') }}',
            validate: true
        });

        $('#date-publish-at').bootstrapMaterialDatePicker({
            format : 'DD/MM/Y - HH:mm'
        });

        $(document).on('keypress', function(e){
            if(e.which == 13) {
                return false;
            }
        });
    </script>
@endpush
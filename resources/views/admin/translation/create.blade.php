@extends('admin.layouts.app')
@section('title')
    {{ __('site.translation.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.translation.title_create'), 'url' =>  route('translation.index')])
        <form class="" action="{{ route('translation.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ __('site.translation.group_key') }} <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="group_key"
                                       class="form-control @error('group_key') is-invalid @enderror"
                                       value="{{ old('group_key') }}"
                                       placeholder="{{ __('site.translation.group_key_hint') }}"/>
                                @error('group_key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @foreach($globalLanguages as $language)
                                <div class="form-group">
                                    <label>Value ({{ strtoupper($language->slug) }}) <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="values[{{ $language->slug }}]"
                                           class="form-control @error('values.' . $language->slug) is-invalid @enderror"
                                           value="{{ old('values.' . $language->slug) }}"
                                           placeholder="{{ __('site.translation.value_hint') }}"/>
                                    @error('values.' . $language->slug)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-gradient-primary"><i class="far fa-save"></i> {{ __('site.button.save') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
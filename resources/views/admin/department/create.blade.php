@extends('admin.layouts.app')
@section('title')
    {{ __('site.permission.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.department.title_create'), 'url' =>  route('departments.index')])
        <form class="" action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ __('site.department.name') }}</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="{{ __('site.department.name') }}"/>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div  id="description" class="form-group">
                                <label>{{ __('site.department.description') }}</label>
                                <div>
                                    <textarea class="form-control" name="description" placeholder="{{ __('site.department.description') }}" rows="5">{{ old('site.department.description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" name="submitter" value="apply" class="btn btn-lg btn-gradient-primary w-100"><i class="far fa-save"></i> {{ __('site.button.save') }}</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="submitter" value="save" class="btn btn-lg btn-gradient-purple w-100"><i class="fas fa-sign-out-alt"></i> {{ __('site.button.save_and_exit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
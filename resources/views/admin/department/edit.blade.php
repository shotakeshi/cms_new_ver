@extends('admin.layouts.app')
@section('title')
    {{ __('site.department.title') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.layouts.partials.page-title-box', ['name' => __('site.department.title_edit'), 'url' =>  route('departments.index')])
        <form action="{{ route('departments.update', $department) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('site.department.name') }}</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $department->name) }}" placeholder="{{ __('site.department.name') }}"/>
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="description">
                                <label>{{ __('site.department.description') }}</label>
                                <div>
                                    <textarea class="form-control" name="description" placeholder="{{ __('site.department.description') }}" rows="5">{{ old('description', $department->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" name="submitter" value="apply" class="btn btn-lg btn-gradient-primary w-100 font-light"><i class="far fa-save"></i> {{ __('site.button.save') }}</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="submitter" value="save" class="btn btn-lg btn-gradient-purple w-100"><i class="fas fa-sign-out-alt"></i> {{ __('site.button.save_and_exit') }}</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="mt-0 mb-2 header-title">{{ __('site.admin.list') }}</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="20">#</th>
                                            <th>{{ __('site.department.name') }}</th>
                                            <th style="width: 400px">{{ __('site.department.positions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department->admins as $admin)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->position->name ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="mt-0 mb-2 header-title">{{ __('site.department.positions') }}</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-center" width="20">#</th>
                                        <th style="width: 400px">{{ __('site.department.positions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department->positions as $k => $v)
                                            <tr>
                                                <td class="text-center" width="20">{{ $loop->iteration }}</td>
                                                <td>{{ $v->name ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
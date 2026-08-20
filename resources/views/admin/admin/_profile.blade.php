<form action="{{ route('admins.update', $admin) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="form-group row">
                <div class="col-lg-3">
                    <x-admin::forms.single_file
                            name="file"
                            label="{{ __('site.page.avatar') }}"
                            accept="image/jpeg,image/png,image/webp"
                    />
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <x-admin::forms.input
                                    name="name"
                                    label="{{ __('site.admin.name') }}"
                                    placeholder="{{ __('site.admin.name') }}"
                                    :value="$admin->name"
                                    required
                            />
                        </div>
                        <div class="col-lg-6">
                            <x-admin::forms.input
                                    name="email"
                                    label="{{ __('site.admin.email') }}"
                                    placeholder="{{ __('site.admin.email') }}"
                                    :value="$admin->email"
                                    required
                            />
                        </div>
                        <div class="col-lg-6">
                            <x-admin::forms.input
                                    name="phone"
                                    label="{{ __('site.admin.phone') }}"
                                    placeholder="{{ __('site.admin.phone') }}"
                                    :value="$admin->phone"
                            />
                        </div>
                        <div class="col-lg-6">
                            <x-admin::forms.input
                                    name="locale"
                                    label="{{ __('site.admin.locale') }}"
                                    placeholder="{{ __('site.admin.locale') }}"
                                    :value="$admin->locale"
                            />
                        </div>
                        <div class="col-lg-6">
                            <x-admin::forms.select
                                    name="status"
                                    label="{{ __('site.admin.status') }}"
                                    :options="\App\Enums\AdminStatus::options()"
                                    option-value="value"
                                    option-label="label"
                                    :selected="$admin->status"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-form-label">{{ __('site.admin.name') }} <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $admin->name) }}" placeholder="{{ __('site.admin.name') }}">
                @error('name')
                    <div class="form-control-feedback text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email" class="col-form-label">{{ __('site.admin.email') }} <span class="text-danger">*</span></label>
                <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $admin->email) }}" placeholder="{{ __('site.admin.email') }}">
                @error('email')
                    <div class="form-control-feedback text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone" class="col-form-label">{{ __('site.admin.phone') }} </label>
                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $admin->phone) }}" placeholder="{{ __('site.admin.phone') }}">
                @error('phone')
                    <div class="form-control-feedback text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label class="col-form-label">{{ __('site.admin.locale') }}</label>
                    <select class="form-control" name="language_id">
                        @foreach($languages as $key => $language)
                            <option value="{{ $key }}">{{ $language }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label">{{ __('site.admin.status') }}</label>
                    <select class="form-control" name="status">
                        @foreach(\App\Enums\AdminStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected($admin->status->value == $status->value)>{{ \App\Enums\AdminStatus::from($status->value)->getName() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label class="col-form-label">{{ __('site.department.title') }}</label>
                    <select class="form-control" name="department_id" id="department">
                        @foreach($departments as $key => $value)
                            <option value="{{ $key }}" @selected($admin->department_id == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label">{{ __('site.department.position') }}</label>
                    <select class="form-control" name="position_id" id='position'></select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <button type="submit" name="submitter" value="profile" class="btn btn-lg btn-gradient-primary w-100">
                        <i class="far fa-save"></i> {{ __('site.button.update') }}</button>
                </div>
                <div class="col-6">
                    <a href="{{ route('admins.index') }}" class="btn btn-lg btn-gradient-danger w-100">
                        <i class="fas fa-arrow-left"></i> {{ __('site.button.back') }}</a>
                </div>
            </div>
        </div>
{{--        <div class="col-4">--}}
{{--            <div class="form-group">--}}
{{--                <label class="col-form-label">{{ __('site.page.avatar') }}</label>--}}
{{--                <input type="file" name="file" @if(isset($admin->avatar)) data-default-file="{{  asset('storage/'.$admin->avatar)  }}" @endif class="dropify @error('file') is-invalid @enderror" />--}}
{{--                <input type="hidden" name="image" id="image" value="{{ isset($admin->avatar) ?? $admin->avatar }}" >--}}
{{--                @error('file')--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $message }}--}}
{{--                    </div>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</form>
@push('scripts')
    <script type="text/javascript">
        $(function () {
            let positions = {!! Js::from($positions) !!};
            let selectedPositionId = {!! Js::from($admin->position_id ?? '') !!};
            let positionDropdown = $("#position");
            let departmentDropdown = $("#department");
            let selected = '';

            loadPositions(departmentDropdown.val());

            departmentDropdown.change(function () {
                loadPositions($(this).val());
            });

            function loadPositions(departmentId) {
                positionDropdown.empty();
                if (positions[departmentId]) {
                    positions[departmentId].forEach(function (position) {
                        selected = (position.id === selectedPositionId) ? "selected" : "";
                        positionDropdown.append(`<option value="${position.id}" ${selected}>${position.name}</option>`);
                    });
                }
            }
        })
    </script>
@endpush
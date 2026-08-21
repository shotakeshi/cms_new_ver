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
                            defaultFile="{{  asset('storage/'.$admin->avatar)  }}"
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
                                    readonly
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
                        </div>
                        <div class="col-lg-6">
                            <x-admin::forms.radio-buttons
                                    label="{{ __('site.admin.locale') }}"
                                    name="language_id"
                                    :options="$languages"
                                    :selected="$admin->language_id"
                            />
                        </div>
                        <div class="col-lg-6">
                            <x-admin::forms.radio-enums
                                    name="status"
                                    label="{{ __('site.admin.status') }}"
                                    :options="\App\Enums\AdminStatus::options()"
                                    :selected="$admin->status?->value"
                            />
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
{{--
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
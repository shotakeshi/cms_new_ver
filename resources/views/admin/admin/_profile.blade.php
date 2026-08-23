<form action="{{ route('admins.update', $admin) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="row">
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
                            <x-admin::forms.select
                                    name="department_id"
                                    label="{{ __('site.department.title') }}"
                                    :options="$departments"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$admin->department_id"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-admin::forms.select
                                    name="position_id"
                                    label="{{ __('site.department.position') }}"
                                    :options="collect()"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$admin->position_id"
                            />
                        </div>
                        <div class="col-lg-12 text-right">
                            <a href="{{ route('admins.index') }}" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-arrow-left"></i> {{ __('site.button.back') }}</a>
                            <button type="submit" name="submitter" value="profile" class="btn btn-sm btn-outline-primary">
                                <i class="far fa-save"></i> {{ __('site.button.update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@push('scripts')
    <script>
        $(document).ready(function () {
            const departments = @json($departments);

            const $department = $('#department_id');
            const $position = $('#position_id');

            // Chỉ có giá trị khi Edit
            const selectedPosition = @json(
                old('position_id', $admin->position_id ?? null)
            );

                function loadPositions(departmentId, selectedId = null) {
                    $position.empty();

                if (!departmentId) {
                    $position.val('').trigger('change');
                    return;
                }

                const department = departments.find(
                    item => String(item.id) === String(departmentId)
                );

                if (!department) {
                    return;
                }

                department.positions.forEach(function (position) {
                    const option = new Option(
                        position.name,
                        position.id
                    );

                    if (
                        selectedId !== null &&
                        String(position.id) === String(selectedId)
                    ) {
                        option.selected = true;
                    }

                    $position.append(option);
                });

                $position.trigger('change');
            }

            // Department thay đổi → load Position
            $department.on('change', function () {
                loadPositions($(this).val());
            });

            // ==========================
            // EDIT: Load position hiện tại
            // ==========================
            if ($department.val()) {
                loadPositions(
                    $department.val(),
                    selectedPosition
                );
            }
        });
    </script>
@endpush
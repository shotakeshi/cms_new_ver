<div class="row">
    <div class="col-lg-12">
        <ul class="nav mb-3" id="pills-tab" role="tablist">
            @foreach($globalLanguages as $key => $language)
                <li class="nav-item mr-3 {{ $key === 0 ? 'show active' : '' }}">
                    <a class="btn btn-outline-danger {{ $key === 0 ? 'active' : '' }}" id="widget_tab" data-toggle="pill" href="#{{ $language->slug }}">
                        {{ $language->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-lg-12">
        <div class="tab-content detail-list border p-3" id="pills-tabContent">
            @foreach($globalLanguages as $key => $language)
                <div class="tab-pane fade mt-0 {{ $key === 0 ? 'show active' : '' }}" id="{{ $language->slug }}">
                    <div class="row">
                        <div class="col-lg-2">
                            <x-admin::forms.single_file
                                    name="{{ $language->slug }}[file]"
                                    label="{{ __('site.widget.image') }}"
                                    accept="image/jpeg,image/png,image/webp"
                            />
                            <hr>
                            <x-admin::forms.single_file
                                    name="{{ $language->slug }}[file_mobile]"
                                    label="{{ __('site.widget.image_mobile') }}"
                                    accept="image/jpeg,image/png,image/webp"
                            />
                        </div>
                        <div class="col-lg-10">
                            <x-admin::forms.input
                                    name="{{ $language->slug }}[title]"
                                    label="{{ __('site.widget.text_title') }}"
                                    placeholder="{{ __('site.widget.text_title') }}"
                            />
                            <x-admin::forms.textarea
                                    name="{{ $language->slug }}[content]"
                                    label="{{ __('site.page.content') }}"
                                    placeholder="{{ __('site.page.content') }}"
                                    rows="10"
                                    required
                                    ckeditor
                            />
                        </div>
                    </div>
                </div><!--end general detail-->
            @endforeach
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('administrator/phoenix/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <!-- Plugins js -->
    <script src="{{ asset('administrator/phoenix/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('administrator/phoenix/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('administrator/assets/ckeditor/ckeditor.js') }}"></script>
@endpush
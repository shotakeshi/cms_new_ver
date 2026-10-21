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
                    @php
                        $content = $widget?->contents()->where('language_code', $language->slug )->first() ?? [];
                        $contentLang = $content?->data ?? [];
                    @endphp
                    <div class="row">
                        <div class="col-lg-12">
                            <x-admin::forms.input
                                    name="{{ $language->slug }}[name]"
                                    label="{{ __('site.widget.button_name') }}"
                                    placeholder="{{ __('site.widget.button_name') }}"
                                    :value="old($language->slug . '.name', $contentLang['name'] ?? '')"
                            />
                            <x-admin::forms.input
                                    name="{{ $language->slug }}[display]"
                                    label="{{ __('site.widget.display_name') }}"
                                    placeholder="{{ __('site.widget.display_name') }}"
                                    :value="old($language->slug . '.display', $contentLang['display'] ?? '')"
                            />
                            <x-admin::forms.input
                                    name="{{ $language->slug }}[url]"
                                    label="{{ __('site.widget.link_url') }}"
                                    placeholder="/contact"
                                    :value="old($language->slug . '.url', $contentLang['url'] ?? '')"
                            />
                        </div>
                        <div class="col-lg-4">
                            <label>
                                {{ __('site.widget.open_link') }}
                            </label>
                            <div class="radio">
                                <input type="radio" name="{{ $language->slug }}[target]" id="radio" value="_parent"
                                       @checked(($contentLang['target'] ?? '_parent') === '_parent')>
                                <label for="radio">
                                    {{ __('site.widget.open_in_parent') }}
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <input type="radio" name="{{ $language->slug }}[target]" id="radio1" value="_blank"
                                       @checked(($contentLang['target'] ?? '_blank') === '_blank')>
                                <label for="radio1">
                                    {{ __('site.widget.open_in_new_tab') }}
                                </label>
                            </div>
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
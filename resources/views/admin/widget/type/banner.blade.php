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
                        <div class="col-lg-2">
                            <input type="hidden" name="{{ $language->slug }}[file]"
                                   value="{{ !empty($contentLang['file']) ? $contentLang['file'] : null }}">
                            <x-admin::forms.single_file
                                    name="{{ $language->slug }}[file]"
                                    label="{{ __('site.page.avatar') }}"
                                    accept="image/jpeg,image/png,image/webp"
                                    :default-file="!empty($contentLang['file'])
                                                ? asset('storage/' . $contentLang['file'])
                                                : null"
                            />
                        </div>
                        <div class="col-lg-10">
                            <x-admin::forms.input
                                    small="{{ __('site.widget.alt_description') }}"
                                    name="{{ $language->slug }}[alt]"
                                    label="{{ __('site.widget.alt') }}"
                                    placeholder="{{ __('site.widget.alt') }}"
                                    :value="old($language->slug . '.alt', $contentLang['alt'] ?? '')"
                            />
                            <div class="row">
                                <div class="col-lg-8">
                                    <x-admin::forms.input
                                            small="{{ __('site.widget.http_example') }}"
                                            name="{{ $language->slug }}[url]"
                                            label="{{ __('site.widget.url') }}"
                                            placeholder="{{ __('site.widget.url') }}"
                                            :value="old($language->slug . '.url', $contentLang['url'] ?? '')"
                                    />
                                </div>
                                <div class="col-lg-4">
                                    <label for="{{ $language->slug }}[target]" class="col-form-label">
                                        {{ __('site.widget.target') }}
                                    </label>
                                    @php($target = $contentLang['target'] ?? '_blank')
                                    <select name="{{ $language->slug }}[target]" class="form-control">
                                        <option @selected($target === '_blank') value="_blank">{{ __('site.widget.target_blank') }}</option>
                                        <option @selected($target === '_self') value="_self">{{ __('site.widget.target_self') }}</option>
                                        <option @selected($target === '_parent') value="_parent">{{ __('site.widget.target_parent') }}</option>
                                    </select>
                                    <small class="form-text text-muted">{{ __('site.widget.target_example') }}</small>
                                </div>
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
    <script>
        $('.dropify').dropify().on('dropify.afterClear', function(event, element) {
            const name = this.name;
            $(`input[name="${name}"]`).val(null);
        });
    </script>
@endpush
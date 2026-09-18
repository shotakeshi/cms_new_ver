<div class="row">
    <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
        @foreach($globalLanguages as $language)
            <li class="nav-item">
                <a class="btn btn-outline-danger" id="widget_tab" data-toggle="pill" href="#{{ $language->slug }}">
                    {{ $language->name }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content detail-list" id="pills-tabContent">
        @foreach($globalLanguages as $language)
            <div class="tab-pane fade" id="{{ $language->slug }}">
                {{ $language->name }}
            </div><!--end general detail-->
        @endforeach
    </div>
</div>
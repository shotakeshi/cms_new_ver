<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('site.dashboard') }}</a></li>
                    <li class="breadcrumb-item active">{{ $name }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ $name }}
                @if(!empty($url))
                    <a href="{{ $url }}" class="btn btn-sm btn-outline-gray waves-effect waves-light text-gray ml-2">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('site.button.back') }}
                    </a>
                @endif
            </h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
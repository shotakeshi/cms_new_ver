<a class="text-danger" href="javascript:void(0)" data-toggle="modal" data-animation="bounce" data-target=".bs-meta-keyword-modal-lg"> <i class="fa fa-question-circle"></i></a>
<div class="modal fade bs-meta-keyword-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myMetaKeyword" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myMetaKeyword">{{ __('seo.intro_meta_keyword') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                {!! __('seo.content_meta_keyword') !!}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
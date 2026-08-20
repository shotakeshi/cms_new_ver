@props([
    'backUrl' => null,
    'showReset' => false,
    'showSave' => true,
    'showSaveExit' => true,
])
<hr>
<div class="row g-2">
    {{-- Reset --}}

    {{-- Save --}}
    <div class="col-lg-12 text-right">
        @if ($showReset)
            <button type="reset" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                <i class="fas fa-redo mr-1"></i>
                {{ __('site.button.reset') }}
            </button>
        @endif
        @if ($showSave)
            <button type="submit" name="submitter" value="apply" class="btn btn-sm btn-outline-primary ml-2 waves-effect waves-light">
                <i class="far fa-save mr-1"></i>
                {{ __('site.button.save') }}
            </button>
        @endif
        @if ($showSaveExit)
            <button type="submit" name="submitter" value="save" class="btn btn-sm btn-outline-primary ml-2 waves-effect waves-light">
                <i class="fas fa-sign-out-alt mr-1"></i>
                {{ __('site.button.save_and_exit') }}
            </button>
        @endif
    </div>
</div>
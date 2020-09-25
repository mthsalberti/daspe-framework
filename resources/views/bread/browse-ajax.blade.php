<div id="for-ajax-only-render-this-section-content" class="for-ajax-only-render-this-section-content">
    <div class="progress md-progress primary-color-dark @if(!isset($is_async)) daspe-transparent @endif ">
        <div class="@if(!isset($is_async)) daspe-transparent @endif indeterminate "></div>
    </div>
    @if($modelRaw->useCardForBrowse || request()->input('use-card-layout'))
        @include('daspeweb::bread.browse-table-fields-card-version')
    @else
        <div class="table-responsive" >
            <table class="table  mb-0" id="dataTable" style="white-space: nowrap;">
                @include('daspeweb::bread.browse-table-fields')
            </table>
        </div>
    @endif
    <hr class="my-0">
    <div class="d-flex justify-content-between" style="    float: right;">
        <nav class="my-4 ">
            @if(!isset($is_async))
                {{ $dataTypeContent->links('daspeweb::pagination.bootstrap-4') }}
            @endif
        </nav>
    </div>
</div>


@php
    $fieldJson = json_encode($relatedList->fields);
    $relatedList->constructDefaultCreationButton($modelInfo);
@endphp
<input type="hidden" name="fields-for-{{$relatedListModelInfo->slug}}" value="{{$fieldJson}}">

@foreach($relatedList->relatedButtons as $button)
    <a href="{{$button->makeLink($modelInstance)}}"
       class="btn btn-outline-primary btn-rounded btn-sm {{$button->isModal ? 'is_modal' : ''}} {{$button->makeCssClass()}}">
        {{$button->name}}
    </a>
@endforeach

<div class="card mt-1 card-cascade narrower z-depth-1">
    <div class="px-4" id="main-for-ajax-only-render-this-section-{{$relatedListModelInfo->slug}}"
         data-related-list="{{$relatedListModelInfo->slug}}"
         data-fk="{{$relatedList->getForeignKey($modelInfo)}}"
         data-use-card-layout="{{$relatedList->useCard}}"
         data-fk-id="{{$modelInstance->id}}">
    </div>
</div>

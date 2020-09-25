@if($field->isLinkForMain)
    <div class="readmore"><a class="blue-text" href="/admin/{{\Daspeweb\Framework\DaspewebHelper::slug()}}/{{$modelInstance->id}}">
            {{  str_limit( $modelInstance->{$field->apiName}, $field->strLimit )}}</a> </div>
@else
    <div class="readmore">{{ str_limit( $modelInstance->{$field->apiName}, '80' )}}</div>
@endif

@php
    if ($modelInstance->{$field->method} == null) return '';
    $relatedData = $modelInstance->{$field->method};
@endphp
@if($field->relatedLink != null && !$field->makeItNotAlink)
    @php
        $link = '';
        if($field->relatedLink != null){
            $link = preg_replace('/(.*)({id})/', '$1' , $field->relatedLink) . $relatedData->id;
        }
    @endphp
    <a class="blue-text" target="{{$field->target}}" href="{{$link}}"
       title="{{$relatedData->{$field->displayRelated} }}">
        {{ str_limit($relatedData->{$field->displayRelated}, $field->strLimit) }}
    </a>
@else
    {{ str_limit($relatedData->{$field->displayRelated}, $field->strLimit) }}
@endif

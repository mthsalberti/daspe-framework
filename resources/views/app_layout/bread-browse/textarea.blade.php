@php
    $value = $modelInstance->{$field->apiName};
    $value = $value==null? '' : $value;
    $slug = \Daspeweb\Framework\DaspewebHelper::slug();
@endphp
@if(mb_strlen( $value ) > 30)
    <span class="">{{mb_substr($value, 0, 30)}}
        <a href="#" class="badge badge-primary text-white" data-slug="{{$slug}}"  data-field="{{$field->apiName}}" data-id="{{$modelInstance->id}}"
           onclick="event.preventDefault(); loadMode(this);">ver tudo...
        </a>
    </span>
@else
    <span>{{$value}} <span>
@endif

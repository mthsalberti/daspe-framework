@php
    $belongsToData = $modelInstance->{$field->method};
    $val = '';
    $link = '';
    if ($belongsToData != null){
        $val = $belongsToData->{$field->fieldsToShowOnInput[0]};
        if($field->relatedLink != null){
            $link = preg_replace('/(.*)({id})/', '$1' , $field->relatedLink) . $belongsToData->id;
        }
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @if($field->makeItNotAlink)
            <span class="form-control border-0 read-input-email ">{{ $val }}</span>
        @else
            <a href="{{$link}}" style="min-height: 38px;" target="{{$field->target}}" type="text" name="{{$field->apiName}}" id="{{$field->apiName}}" class="form-control border-0 read-input-email blue-text">
                {{ str_limit($val, $field->strLimit) }}
            </a>
        @endif
        <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

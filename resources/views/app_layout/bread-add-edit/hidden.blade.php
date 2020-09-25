@php
    $value =
        $create
        ? old($field->apiName)
        : old($field->apiName, $modelInstance->{$field->apiName});
    if ($value == null || $value == ''){
        $value = $field->default;
    }
@endphp
<input type="hidden" name="{{$field->apiName}}" id="{{$field->apiName}}" class="form-control"
       value="{{$value}}">

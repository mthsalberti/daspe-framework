@php
    $dateFixed = null;
    try{
        $dateFixed = \Carbon\Carbon::parse($modelInstance->{$field->apiName})->format('d/m/Y H:i');
    }catch (Exception $e){
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <input type="text"
               name="{{$field->apiName}}" id="{{$field->apiName}}"
               class="form-control input-date-time"
               value="{{$create ? old($field->apiName) : old($field->apiName ,$dateFixed) }}">
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>


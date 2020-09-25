@php
    $value = '';
    if ($modelInstance->{$field->apiName} == null || $modelInstance->{$field->apiName} == "0000-00-00"){
        $value = '';
    }else if($field->format != null){
        $value = \Carbon\Carbon::parse($modelInstance->{$field->apiName})->format($field->format);
    }else if(config('daspeweb.date_format') <> null){
        $value = \Carbon\Carbon::parse($modelInstance->{$field->apiName})->format(config('daspeweb.date_format'));
    }else{
        $value = $modelInstance->{$field->apiName};
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <input type="text" name="{{$field->apiName}}" id="{{$field->apiName}}"
               class="form-control " value="{{$value }}" readonly>
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

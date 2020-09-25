@php
    $value = '';
    if ($modelInstance->{$field->apiName} == null || $modelInstance->{$field->apiName} == "0000-00-00"){
        $value = '';
    }else if($field->format != null){
        $value = \Carbon\Carbon::parse($modelInstance->{$field->apiName})->format($field->format);
    }else if (config('daspeweb.timestamps_format') <> ''){
        $value = \Carbon\Carbon::parse($modelInstance->{$field->apiName})->format(config('daspeweb.timestamps_format'));
    }else{
        $value = $modelInstance->{$field->apiName};
    }
@endphp

{{$value}}

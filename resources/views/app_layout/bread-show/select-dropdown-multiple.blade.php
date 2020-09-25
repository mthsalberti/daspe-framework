@php
    $selectedArr =
        $modelInstance->{$field->apiName} == null
        || $modelInstance->{$field->apiName} == 'null'
        || $modelInstance->{$field->apiName} == ''
        ? [] : json_decode($modelInstance->{$field->apiName});
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="mt-2 pt-2">
            @foreach($selectedArr as $key => $value)
                <span class="badge badge-info">{{$value}}</span>
            @endforeach
            <label class="active label-active-force" for="{{$field->apiName}}"
                   style="white-space: nowrap">{{$field->label}}</label>
        </div>

    </div>
</div>

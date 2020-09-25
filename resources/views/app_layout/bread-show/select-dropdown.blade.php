@php
    $realValue = $modelInstance->{$field->apiName};
    $value = array_key_exists($realValue, $field->options) ?  $field->options[$realValue] : $realValue;
    $color = isset($field->colorByOption[strtolower($realValue)]) ? $field->colorByOption[strtolower($realValue)] : 'badge-info';
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
            @if($field->showAsBadge != '')
                <span class="badge {{$color}}">{{$value}}</span>
            @else
                <input type="text" name="{{$field->apiName}}" id="{{$field->apiName}}" class="form-control " value="{{$modelInstance->{$field->apiName} }}" readonly>
            @endif

        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>
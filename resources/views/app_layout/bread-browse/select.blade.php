@php
    $realValue = $modelInstance->{$field->apiName};
    $value = array_key_exists($realValue, $field->options) ?  $field->options[$realValue] : $realValue;
    $color = isset($field->colorByOption[strtolower($realValue)]) ? $field->colorByOption[strtolower($realValue)] : 'badge-info';
@endphp
@if($field->showAsBadge)
    <span class="badge font-size-0_8 {{$color}} ">{{$value}}</span>
@else
    {{$modelInstance->{$field->apiName} }}
@endif

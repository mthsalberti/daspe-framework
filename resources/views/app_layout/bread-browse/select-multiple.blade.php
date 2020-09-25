@php
    $selectedArr = $modelInstance->{$field->apiName} == null ? [] : json_decode($modelInstance->{$field->apiName});
    $selectedArr = $selectedArr == null ? [] : $selectedArr;
@endphp
@foreach($selectedArr as $key => $value)
    {{--{{dd($selectedValues, $key, $value)}}--}}

        {{--<span class="badge {{isset($optionsColor[$key]) ? $optionsColor[$key]: "badge-info"  }}">{{$value}}</span>--}}
        <span class="badge badge-info">{{$value}}</span>

    {{--{{ $options->options->{$item} . (!$loop->last ? ', ' : '') }}--}}
@endforeach
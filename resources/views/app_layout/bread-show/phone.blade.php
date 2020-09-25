@php
    $ehFixo = false;
    $rawVal = $string = preg_replace("/[^a-z0-9.]+/i", "", $modelInstance->{$field->apiName});
    $len = strlen($rawVal);
    if ($len == 11 || $len == 10){
        $removedDDD = substr($rawVal, 2);
        $firstNumber = intval(substr($removedDDD, 0, 1));
        if($firstNumber >= 2 && $firstNumber <= 5 ){
            $ehFixo = true;
        }else{
            if (strpos($rawVal, '55') === false) {
                $rawVal = '55'.$rawVal;
            }
        }
    }else{
        $ehFixo = true;
    }

    if (!$ehFixo){
        $link =  'https://wa.me/'.$rawVal;
    }else{
        $link =  'tel:'.$modelInstance->{$field->apiName};
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @if($field->makeItNotALink)
            <input type="text" name="{{$field->apiName}}" id="{{$field->apiName}}" class="form-control " value="{{$modelInstance->{$field->apiName} }}" readonly>
        @else
            <a href="{{$link}}" target="_blank"
               type="text" name="{{$field->apiName}}" id="{{$field->apiName}}"
               class="form-control border-0 read-input-email blue-text" style="height: 37px;">
                @if(!$ehFixo)<i class="fab fa-whatsapp green-text"></i>@endif {{$modelInstance->{$field->apiName} }}</a>
        @endif

        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>
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
<a href="{{$link}}" target="_blank" class="blue-text">@if(!$ehFixo)<i class="fab fa-whatsapp green-text"></i>@endif {{$modelInstance->{$field->apiName} }}</a>
{{----}}
@php
    $error = '';
        if($errors->has($field)){
            $error = $errors->get($field)[0];
        }
@endphp
@if($errors->has($field))
<span style="color: red; font-size: 14px;">{{$error}}</span>
@endif
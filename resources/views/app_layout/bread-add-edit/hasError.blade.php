@php
    $error = '';
        if($errors->has($field)){
            $error = $errors->get($field)[0];
        }
@endphp
@if($errors->has($field))
    <span title="{{$error}}" class="error-info">{{$error}}</span>
@endif

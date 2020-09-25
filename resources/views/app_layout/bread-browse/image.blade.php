@php
    $imgJson = json_decode($modelInstance->{$field->apiName}, true);
    if(count($imgJson) == 0){
        $imgJson[0] = [
           'path-low' => '',
        'path' => '',
        'width' => '',
        'height' => '',
        ];
    }
@endphp
<div class="mdb-lightbox no-margin">
    <figure class="">
        <a href="{{\Storage::disk('public')->url($imgJson[0]['path'])}}" data-size="{{$imgJson[0]['width']}}x{{$imgJson[0]['height']}}">
            <img src="{{\Storage::disk('public')->url($imgJson[0]['path-low'])}}" class="z-depth-2 pt-1" style="max-height: 45px;">
        </a>
    </figure>
</div>

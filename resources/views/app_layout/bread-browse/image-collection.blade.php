@php
    $imgCollJson = json_decode($modelInstance->{$field->apiName}, true);
    if ($imgCollJson == null) $imgCollJson = [];
@endphp
<div class="mdb-lightbox no-margin">
    @foreach($imgCollJson as $imgJson)
        @php
            if(count($imgJson) == 0){
                $imgJson = [
                    'path-low' => '',
                    'path' => '',
                    'width' => '',
                    'height' => '',
                ];
            }
        @endphp
        <figure class="mr-1 mb-1">
            <a href="{{\Storage::disk('gcs')->url($imgJson['path'])}}" data-size="{{$imgJson['width']}}x{{$imgJson['height']}}">
                <img src="{{\Storage::disk('gcs')->url($imgJson['path'])}}" class="z-depth-2 pt-1" style="max-height: 45px;">
            </a>
        </figure>
    @endforeach
</div>

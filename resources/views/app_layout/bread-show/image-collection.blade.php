@php
    $imgCollJson = json_decode($modelInstance->{$field->apiName}, true);
    if ($imgCollJson == null){
        $imgCollJson = [];
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
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
                <figure class="mx-2">
                    <a href="{{\Storage::disk('gcs')->url($imgJson['path'])}}" data-size="{{$imgJson['width']}}x{{$imgJson['height']}}">
                        <img src="{{\Storage::disk('gcs')->url($imgJson['path-low'])}}" class="z-depth-2 pt-1" style="max-height: 60px;">
                    </a>
                </figure>
            @endforeach
        </div>
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>
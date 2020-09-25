<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="mdb-lightbox no-margin">
            <figure class="">
                @php
                    $imgCollJson = json_decode($modelInstance->{$field->apiName}, true);
                    if(count($imgCollJson) == 0){
                        $imgCollJson[0] = [
                            'path-low' => '',
                            'path' => '',
                            'width' => '',
                            'height' => '',
                        ];
                    }
                @endphp
                <a href="{{\Storage::disk(config('filesystems.cloud'))->url($imgCollJson[0]['path'])}}"
                   data-size="{{$imgCollJson[0]['width']}}x{{$imgCollJson[0]['height']}}">
                    <img src="{{\Storage::disk(config('filesystems.cloud'))->url($imgCollJson[0]['path-low'])}}"
                         class="z-depth-2 pt-1" style="max-height: 60px;">
                </a>
            </figure>
        </div>
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

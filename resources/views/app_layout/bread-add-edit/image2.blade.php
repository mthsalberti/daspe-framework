@php
    $imgCollJson = json_decode($modelInstance->{$field->apiName}, true);
    if(count($imgCollJson) == 0){
        $imgCollJson[0] = [
            'path-low' => '',
        ];
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch img-controller">
    <div class="md-form form-sm w-100">
        <label class="active label-active-force mb-3 pb-3 mt-2" for="{{$field->apiName}}">{{$field->label}}</label>
        <div class="file-upload-wrapper" >
            <div class="input-group mb-3">
                <input type="file" id="{{$field->apiName}}"
                       class="file-upload"
                       name="{{$field->apiName}}"
                       accept="image/x-png,image/gif,image/jpeg,image/jpg/*;capture=camera"
                       @if(!$create)
                       data-default-file="{{\Storage::disk(config('filesystems.cloud'))->url($imgCollJson[0]['path-low'])}}"
                       @endif
                       data-height="200" data-max-file-size="9M" style="min-height: 200px !important;"/>
                <input type="hidden" id="{{$field->apiName}}_aux" class="aux" name="{{$field->apiName}}_aux" value="0" />
            </div>
        </div>
    </div>
</div>

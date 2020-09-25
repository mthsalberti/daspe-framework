<div class="{{$field->width}} mb-3 d-flex align-items-stretch img-controller">
    <div class="row m-0 p-0 w-100">
        <div class="md-form form-sm w-100">
            <label class="active label-active-force mb-3 pb-3 mt-2" for="{{$field->apiName}}">{{$field->label}}</label>
            <div class="file-upload-wrapper">
                <div class="input-group mb-3">
                    <input type="file" id="input-file-now" data-max-file-size="6M"  class="file-upload" name="{{$field->apiName}}[]" multiple />
                </div>
            </div>
            @if(!$create)
                <div class="row">
                    @php
                        $imgCollJson = json_decode($modelInstance->{$field->apiName}, true);
                    @endphp
                    @foreach($imgCollJson as $img)
                        <div class="col-6 col-md-3 col-lg-2 mt-3  d-flex align-items-stretch  ">
                            <div class="input-group mb-3">
                                <div class="file-upload-wrapper">
                                    <input type="file" id="input-file-now-custom-1" class="file-upload"
                                           accept="image/x-png,image/gif,image/jpeg,image/jpg/*;capture=camera"
                                          data-max-file-size="6M"
					   name="{{$field->apiName}}_replace[]"
                                           data-default-file="{{\Storage::disk('public')->url($img['path-low'])}}" />
                                    <input type="hidden" id="{{$field->apiName}}_aux" class="aux" name="{{$field->apiName}}_aux[]" value="0" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>



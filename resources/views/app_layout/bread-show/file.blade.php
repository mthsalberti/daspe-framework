<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @php
            $file = json_decode($modelInstance->{$field->apiName}, true);
        @endphp
        @if($file != '')
           <a href="{{asset(\Storage::disk(config('filesystems.cloud'))->url($file))}}" class="btn-floating blue-gradient" id="{{$field->apiName}}"><i class="fas fa-paperclip"></i></a>
         @endif
        <label class="active label-active-force"    for="{{$field->apiName}}"  style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

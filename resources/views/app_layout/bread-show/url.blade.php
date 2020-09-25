<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <a href="{{ $field->prefix .$modelInstance->{$field->apiName} }}" target="_blank"
           type="text" name="{{$field->apiName}}" id="{{$field->apiName}}"
           class="form-control border-0 read-input-email blue-text"
           style="height: 37px;     overflow: hidden;">
            {{ $modelInstance->{$field->apiName} }}</a>
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

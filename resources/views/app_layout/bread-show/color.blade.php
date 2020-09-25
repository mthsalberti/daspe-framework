<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <input type="text" name="{{$field->apiName}}" id="{{$field->apiName}}"
               class="form-control border-0"
               style="height: 34px; background-color: {{$modelInstance->{$field->apiName} }} !important;" readonly >
        <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

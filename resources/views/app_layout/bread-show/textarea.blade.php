<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <p class="mt-2">{{$modelInstance->{$field->apiName} }}</p>
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>
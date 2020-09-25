<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <input type="text" name="{{$field->apiName}}" id="{{$field->apiName}}" class="form-control "
               value="{{$modelInstance->{$field->apiName} }}" readonly>
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <input {{$field->readonlyHTML ? 'readonly': ''}}  type="number" name="{{$field->apiName}}" step="1" id="{{$field->apiName}}" class="form-control"
               value="{{$create ? old($field->apiName) : old($field->apiName, $modelInstance->{$field->apiName}) }}">
        <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

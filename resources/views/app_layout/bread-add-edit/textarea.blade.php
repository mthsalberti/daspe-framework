<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <textarea {{$field->readonlyHTML ? 'readonly': ''}}
                name="{{$field->apiName}}"
                id="{{$field->apiName}}"
                class="md-textarea w-100"
                >{{$create ? old($field->apiName) : old($field->apiName, $modelInstance->{$field->apiName}) }}</textarea>
        <label for="{{$field->apiName}}" class="active label-active-force">{{$field->label}}</label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName, 'top' => '100'])
    </div>
</div>



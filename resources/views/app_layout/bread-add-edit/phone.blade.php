<div class="col-12 col-md-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <input
               autocomplete="off" {{$field->readonlyHTML ? 'readonly': ''}}
               type="text"
               name="{{$field->apiName}}"
               id="{{$field->apiName}}"
               class="form-control has-mask is-phone"
               data-mask-daspe="{{$field->mask}}"
               value="{{$create ? old($field->apiName) : old($field->apiName, $modelInstance->{$field->apiName}) }}">
        <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>

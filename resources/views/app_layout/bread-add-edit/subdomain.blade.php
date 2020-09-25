<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="row m-0 p-0">
            <div class=" m-0 p-0 ">
                <span class="form-control border-0 pb-0 pt-2 ">https://</span>
            </div>
            <div class=" m-0 p-0">
                <input type="text" name="{{$field->apiName}}" id="{{$field->apiName}}" class="form-control" style="max-width: 120px;"
                       value="{{$create ? old($field->apiName) : old($field->apiName, $modelInstance->{$field->apiName}) }}">
            </div>
            <div class=" m-0 p-0">
                <span class="form-control border-0 pb-0 pt-2 ">.soumodelo.com.br</span>
            </div>

        </div>

        <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>

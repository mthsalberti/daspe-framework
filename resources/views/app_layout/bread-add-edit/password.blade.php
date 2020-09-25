<div class="col-6 m-0 p-0">
    <div class="row m-0 p-0">
        <div class="col-6 mb-3 d-flex align-items-stretch">
            <div class="md-form form-sm w-100">
                <input type="password"
                       name="{{$field->apiName}}"
                       id="{{$field->apiName}}"
                       class="form-control "
                       placeholder="*******"
                       value="">
                <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
                @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
            </div>
        </div>
        <div class="col-6 mb-3 d-flex align-items-stretch">
            <div class="md-form form-sm w-100">
                <input type="password"
                       name="{{$field->apiName}}_confirmation"
                       id="{{$field->apiName}}_confirmation "
                       class="form-control "
                       placeholder="*******"
                       value="">
                <label class="active label-active-force" for="{{$field->apiName}}_confirmation" style="white-space: nowrap">{{$field->label}} (confirmação)</label>

            </div>
        </div>
    </div>
</div>

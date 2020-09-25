<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="form-check">
            <div class="md-form">
                <input name="{{$row->field}}"
                       type="text"
                       id="{{$row->field}}"
                           class="form-control timepicker "
                       value="{{$create ? old($field->apiName) : old($field->apiName, $modelInstance->{$field->apiName}) }}">
                <label for="{{$row->field}}" >{{$row->display_name}}</label>
                @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $row->field])
            </div>
        </div>
    </div>
</div>

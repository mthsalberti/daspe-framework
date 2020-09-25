<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <label for="{{$field->apiName}}" class="active label-active-force">{{$field->label}}</label>
        <div class="form-check form-check-inline">
            @foreach($field->options as $key => $value)
                <input
                        {{old($field->apiName, $modelInstance->{$field->apiName}) == $key ? 'checked' : ''}}
                        style="margin-left: -10px;" type="radio" class="form-check-input" id="{{$field->apiName}}_{{$key}}"
                        name="{{$field->apiName}}" value="{{$key}}">
                <label class="form-check-label" for="{{$field->apiName}}_{{$key}}">{{$value}}</label>
            @endforeach
            @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
        </div>
    </div>
</div>

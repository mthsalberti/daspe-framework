<div class="{{$field->width}} mb-3 pb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="form-check">
            <input type="hidden" value="0" name="{{$field->apiName}}" checked>
            <input type="checkbox"
                   name="{{$field->apiName}}"
                   id="{{$field->apiName}}"
                   class="form-control form-check-input"
                   value="1"
                    @if($create)
                        @if(old($field->apiName) == '1' || $field->defaultOn) checked @endif
                    @else
                        @if( $modelInstance->{$field->apiName} == '1') checked @endif
                    @endif
                  >
            <label class="form-check-label" for="{{$field->apiName}}">{{$field->label}}</label>
            @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
        </div>
    </div>
</div>

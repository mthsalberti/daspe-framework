<div class="{{$field->width}} mb-3 pb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="form-check pt-2 ">
            <input type="hidden" value="0" name="{{$field->apiName}}" checked>
            <input type="checkbox"
                   name="{{$field->apiName}}"
                   id="{{$field->apiName}}"
                   class="form-control form-check-input"
                   value="1"
                   disabled
                   @if( $modelInstance->{$field->apiName} == 1 || $modelInstance->{$field->apiName} == "on") checked @endif
            >
            <label class="form-check-label " for="{{$field->apiName}}">{{$field->label}}</label>
        </div>
    </div>
</div>

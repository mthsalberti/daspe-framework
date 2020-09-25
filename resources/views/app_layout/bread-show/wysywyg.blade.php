<div class="{{$field->width}} mb-3 pb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="form-check">
            <div class="" style="max-height: 300px; overflow: scroll">
                {!! $modelInstance->{$field->apiName} !!}
            </div>
            <label class="active label-active-force " for="{{$field->apiName}}">{{$field->label}}</label>
        </div>
    </div>
</div>



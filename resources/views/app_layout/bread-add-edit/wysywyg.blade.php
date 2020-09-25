@if($create)
<input name="image" type="file" id="upload" class="d-none" onchange="">
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <label for="{{$field->apiName}}" class="active" style="position: absolute; margin-top: -37px;">{{$field->label}}
            @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])</label>
        <textarea name="{{$field->apiName}}" id="{{$field->apiName}}" class="md-textarea rich-editor">{{old($field->apiName)}}</textarea>
    </div>
</div>
@else
    <input name="image" type="file" id="upload" class="d-none" onchange="">
    <div class="{{$field->width}} mb-3 mt-3 d-flex align-items-stretch">
        <div class="md-form form-sm w-100">
            <label for="{{$field->apiName}}" class="active label-active-force" style="position: absolute; margin-top: -20px;">{{$field->label}}
                @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])</label>
            <textarea name="{{$field->apiName}}"
                      id="{{$field->apiName}}"
                      class="md-textarea rich-editor">{{old($field->apiName, $modelInstance->{$field->apiName} )}}</textarea>
        </div>
    </div>
@endif



@if($create)
<input name="image" type="file" id="upload" class="d-none" onchange="">
<div class="col-12 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <label for="{{$row->field}}" class="active" style="position: absolute; margin-top: -37px;">{{$row->display_name}} @include('daspeweb::bread-add-edit-show.error', ['field' => $row->field])</label>
        <textarea
                name="{{$row->field}}"
                id="{{$row->field}}"
                class="md-textarea rich-editor">{{old($row->field)}}</textarea>
    </div>
</div>
@elseif($edit)
    <input name="image" type="file" id="upload" class="d-none" onchange="">
    <div class="col-12 mb-3 d-flex align-items-stretch">
        <div class="md-form form-sm w-100">
            <label for="{{$row->field}}" class="active" style="position: absolute; margin-top: -37px;">{{$row->display_name}} @include('daspeweb::bread-add-edit-show.error', ['field' => $row->field])</label>
            <textarea
                    name="{{$row->field}}"
                    id="{{$row->field}}"
                    class="md-textarea rich-editor">{{old($row->field, $modelInstance->{$row->field} )}}</textarea>
        </div>
    </div>
@else
    <div class="{{\Src\bread\BreadHelper::handleWidth($optionsFirst)}} mb-3 pb-3 d-flex align-items-stretch">
        <div class="md-form form-sm w-100">
            <div class="form-check">
                <div class="" style="max-height: 300px; overflow: scroll">
                    {!! $modelInstance->{$row->field} !!}
                </div>
                <label class="active label-active-force  pb-2" for="{{$row->field}}">{{$row->display_name}}</label>
            </div>
        </div>
    </div>

@endif



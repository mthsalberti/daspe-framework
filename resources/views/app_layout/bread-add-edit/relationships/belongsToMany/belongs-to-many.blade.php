<div class="{{\Src\bread\BreadHelper::handleWidth($options)}} mb-6 d-flex align-items-stretch relationship-wrapper">
    <div class="col-6" style="padding: 0 !important;">
        <div class="md-form form-sm w-100">
            <div id="{{$field->apiName}}__progressbar" class="progress primary-color-dark m-0 p-0" style="position: absolute; top: 42px; height: 2.7px; display: none;">
                <div class="indeterminate"></div>
            </div>
            <input type="text"
                   name="{{$field->apiName}}_autocomplete"
                   id="{{$field->apiName}}_autocomplete"
                   class="form-control relationship has-many-relationship "
                   value="{{old($field->apiName)}}"
                   data-fieldstosearch="{{$fieldsToSearch}}"
                   data-fieldstoshow="{{$fieldsToShow}}"
                   data-fieldstoload="{{$fieldsToLoad}}"
                   data-input_dependence_before_select-id="{{ isset($dependencies->id) ? $dependencies->id : '' }}"
                   data-input_dependence_before_select-dependence_field="{{isset($dependencies->dependence_field) ? $dependencies->dependence_field : ''}}"
                   data-lookup="{{$options->lookup}}"
                   data-maininputid="{{$options->pivot_table}}"
                   data-extra-script="{{$extraScripts}}"
                   autocomplete="nope">
            <label class="active label-active-force" for="{{$field->apiName}}"
                   data-success="right">{{$options->mainlabel}}
            </label>
            @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
        </div>
    </div>
    <div class="col-6 chip-area" style="padding: 0 !important;">
    </div>
</div>

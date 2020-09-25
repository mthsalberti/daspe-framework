<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @php
            $valueReal = $valuePretty = null;
            if (request()->has($field->apiName)){
                $related = $modelInstance->{$field->method}()->getModel();
                $modelResult = $related::find(request()->input($field->apiName));
                $valuePretty = $modelResult->{$field->fieldsToShowOnInput[0]};
                $valueReal = $modelResult->id;
            }else{
                $belongsToData = $modelInstance->{$field->method};
                $valuePretty = old($field->apiName.'_autocomplete', !is_null($belongsToData) ? $belongsToData->{$field->fieldsToShowOnInput[0]} : '');
                $valueReal = old($field->apiName, !is_null($belongsToData) ? $belongsToData->id : '' );
            }

        @endphp
        <div id="{{$field->apiName}}__progressbar" class="progress primary-color-dark m-0 p-0" style="position: absolute; top: 42px; height: 2.7px; display: none;">
            <div class="indeterminate"></div>
        </div>
        <input type="hidden" name="{{$field->apiName}}"
               id="{{$field->apiName}}"
               value="{{$valueReal != null ? $valueReal : old($field->apiName)}}" >
        <input type="text"
               name="{{$field->apiName}}_autocomplete"
               id="{{$field->apiName}}_autocomplete"
               class="form-control relationship "
               value="{{$valuePretty != null ? $valuePretty : old($field->apiName.'_autocomplete')}}"
               data-fieldstosearch="{{json_encode($field->fieldsToSearchFor)}}"
               data-fieldstoshow="{{json_encode($field->fieldsToShowOnInput)}}"
               data-fieldstoload="{{json_encode($field->fieldsToRetrieveOnSearch)}}"
               data-filterbeforesearch="{{json_encode($field->filterBeforeSearch)}}"
               data-fixedfilter="{{json_encode($field->fixedFilter)}}"
               data-lookup="{{$field->lookupSlug}}"
               data-maininputid="{{$field->apiName}}"
               autocomplete="nope"/>
        <label class="active label-active-force" for="{{$field->apiName}}"
               data-success="right">{{$field->label}}
        </label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>

@php
    $options = json_decode($row->details);
    $fieldsToSearch = isset($options->fieldstosearch) ?  implode(",", get_object_vars($options->fieldstosearch)) : [];
    $fieldsToShow = isset($options->fieldstoshow) ?  implode(",", get_object_vars($options->fieldstoshow)) : [];
    $fieldsToLoad = isset($options->fieldstoload) ? implode(",", get_object_vars($options->fieldstoload)) : $fieldsToShow;
    $extraScripts = isset($options->extra_script_call_on_select) ? $options->extra_script_call_on_select : '';
    $dependencies = isset($options->input_dependence_before_select) ? $options->input_dependence_before_select : '';
@endphp
@if($options->type == 'belongsTo')
    @if($options->taggable)
        <div class="{{\Src\bread\BreadHelper::handleWidth($options)}} mb-3 d-flex align-items-stretch">
            <div class="md-form form-sm w-100">
                @if($read)
                    @php
                        $link = '#';
                        if ($modelInstance->{$options->method} != null){
                            $link = preg_replace('/(.*)({id})/', '${1}'.$modelInstance->{$options->id}, $options->url);
                        }
                    @endphp
                    <a href="{{$link}}" class="form-control blue-text border-0" style="border-bottom: 1px solid #bdbdbd !important;">
                        {{ $modelInstance->{$options->method} != null ?  $modelInstance->{$options->method}->{$options->label} : '-' }}
                    </a>
                    <label class="active label-active-force" >{{$row->display_name}}</label>
                @else
                    <select class="mdb-select colorful-select dropdown-primary mt-2"
                            name="{{$row->field}}"
                            id="{{$row->field}}">
                        @foreach(app($options->model)::all() as $rowOption)
                            <option value="{{ $rowOption->id }}"
                                    @if((!$create && $rowOption->id == $modelInstance->{$options->column}) ||  $create && $loop->iteration == 1 ) selected @endif >@foreach($options->fieldstoshow as $fieldToShowAux){{ $rowOption->{$fieldToShowAux} }} @endforeach
                            </option>
                        @endforeach
                    </select>
                    <label class="label-active-force">{{$row->display_name}}</label>
                    @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $row->field])
                @endif
            </div>
        </div>
    @else
        <div class="{{\Src\bread\BreadHelper::handleWidth($options)}} mb-3 d-flex align-items-stretch">
            <div class="md-form form-sm w-100">
                @if($read)
                    @php
                        $link = '#';
                        if ($modelInstance->{$options->method} != null){
                            $link = preg_replace('/(.*)({id})/', '${1}'.$modelInstance->{$options->id}, $options->url);
                        }
                    @endphp
                    <a href="{{$link}}" class="form-control blue-text border-0" style="border-bottom: 1px solid #bdbdbd !important;">
                        {{ $modelInstance->{$options->method} != null ?  $modelInstance->{$options->method}->{$options->label} : '-' }}
                    </a>
                    <label class="active label-active-force" >{{$row->display_name}}</label>
                @else
                    @php
                        $modelResult = null;
                        if (request()->has($row->field)){
                            $rowDetails = json_decode($row->details);
                            $modelResult = app($rowDetails->model)::find(request()->input($row->field));
                            //dd(request()->all(), $row, $rowDetails, $modelResult);
                        }
                    @endphp
                    <div id="{{$row->field}}__progressbar" class="progress primary-color-dark m-0 p-0" style="position: absolute; top: 42px; height: 2.7px; display: none;">
                        <div class="indeterminate"></div>
                    </div>
                    <input type="hidden" name="{{$row->field}}" id="{{$row->field}}" value="{{$modelResult != null ? $modelResult->{$rowDetails->key} : old($row->field)}}" >
                    <input type="text"
                           name="{{$row->field}}_autocomplete"
                           id="{{$row->field}}_autocomplete"
                           class="form-control relationship "
                           value="{{ $create ? ($modelResult != null ? $modelResult->{$rowDetails->label} : old($row->field)) : $modelInstance->id }}"
                           data-fieldstosearch="{{$fieldsToSearch}}"
                           data-fieldstoshow="{{$fieldsToShow}}"
                           data-fieldstoload="{{$fieldsToLoad}}"
                           data-input_dependence_before_select-id="{{ isset($dependencies->id) ? $dependencies->id : '' }}"
                           data-input_dependence_before_select-dependence_field="{{isset($dependencies->dependence_field) ? $dependencies->dependence_field : ''}}"
                           data-lookup="{{$options->lookup}}"
                           data-maininputid="{{$row->field}}"
                           data-extra-script="{{$extraScripts}}"
                           autocomplete="nope">
                    <label class="active label-active-force" for="{{$row->field}}"
                           data-success="right">{{$row->display_name}}
                    </label>
                    @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $row->field])
                @endif
            </div>
        </div>
    @endif


@elseif($options->type == 'belongsToMany')
    @if($options->togglable)
        @include('daspeweb::bread-add-edit-show.relationships.belongsToMany.belongs-to-many-toggle')
    @else
        @include('daspeweb::bread-add-edit-show.relationships.belongsToMany.belongs-to-many')
    @endif


@elseif($options->type == 'hasManyThrough')
    @if($options->togglable)
        @include('daspeweb::bread-add-edit-show.relationships.hasManyThrough.hasManyThroughToggle')
    @else
        @include('daspeweb::bread-add-edit-show.relationships.hasManyThrough.hasManyThrough')
    @endif
@endif

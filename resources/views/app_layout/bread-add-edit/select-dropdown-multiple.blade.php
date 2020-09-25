@php
    /*$json = json_decode($row->details);
    $options = $json->options;
    $jsondefault = isset($json->default) ? $json->default : '';
    $extraScripts = isset($json->extra_script_call_on_select) ? $json->extra_script_call_on_select : '';*/
    $persistedValues = json_decode($modelInstanceAux->{$field->apiName}) ?? [];

@endphp
<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <select class="mdb-select colorful-select dropdown-primary"
                name="{{$field->apiName}}[]"
                id="{{$field->apiName}}" multiple searchable="digite">
            <option value="" disabled selected>Opções</option>
            @foreach($field->options as $key => $value)
                @php
                    $selected = '';
                    if($create){
                        if($key == old($field->apiName) ){
                            $selected = 'selected';
                        }else if($key == $field->default){
                            $selected = 'selected';
                        }
                    }else{
                        if($key == old($field->apiName) ){
                            $selected = 'selected';
                        }else if(in_array($key, $persistedValues)){
                            $selected = 'selected';
                        }else if($key == $field->default){
                            $selected = 'selected';
                        }
                    }
                @endphp
                <option value="{{$key}}" {{$selected}}>{{trim($value)}}</option>
            @endforeach
        </select>
        <label class="label-active-force">{{$field->label}}</label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>

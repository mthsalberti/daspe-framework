@php
    /*$json = json_decode($row->details);
    $options = $json->options;
    $jsondefault = isset($json->default) ? $json->default : '';
    $extraScripts = isset($json->extra_script_call_on_select) ? $json->extra_script_call_on_select : '';*/

@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <select class="mdb-select colorful-select dropdown-primary "
                name="{{$field->apiName}}"
                id="{{$field->apiName}}"
                data-extra-script="">
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
                        }else if($key == $modelInstance->{$field->apiName}){
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

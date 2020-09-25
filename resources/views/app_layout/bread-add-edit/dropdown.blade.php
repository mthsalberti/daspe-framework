{{--{{dd(old($row->field))}}--}}
@php
    $json = json_decode($row->details);
    $options = $json->options;
    $jsondefault = isset($json->default) ? $json->default : '';
    $extraScripts = isset($json->extra_script_call_on_select) ? $json->extra_script_call_on_select : '';
@endphp
<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @if($read)
            @if($multiple)
                @php $selectedValues = json_decode($data->{$row->field}); @endphp
                <div id="{{$row->field}}">
                    @foreach($options as $key => $value)
                        @if(in_array($key, $selectedValues))
                            <span class="badge badge-info">{{$value }}</span>
                        @endif
                    @endforeach
                </div>
            @else
                <div id="{{$row->field}}"  class="form-control border-0" style="border-bottom: 1px solid #bdbdbd !important;">
                    {{ $data->{$row->field} }}
                </div>
            @endif
            <label class="label-active-force">{{$row->display_name}}</label>
        @else
            <select class="mdb-select colorful-select dropdown-primary mt-2"
                    name="{{$row->field}}@if($multiple)[]@endif"
                    id="{{$row->field}}"
                    data-extra-script="{{$extraScripts}}"
                    @if($multiple)  multiple @endif>
                <option value="" disabled selected>Opções</option>
                @foreach($options as $key => $value)
                    @php
                        $selected = '';
                        if($multiple){
                            if (old($row->field) != null){
                                $selected = in_array($key, old($row->field)) ? 'selected' : '';
                            }
                        }else{
                            if ($edit){
                                $selected = $key == $modelInstance->{$row->field} ? 'selected' : '';
                            }else{
                                $selected = old($row->field) == $key ? 'selected' : '';
                            }
                        }
                        if($key ==  $jsondefault && $selected == ''){
                            $selected = 'selected';
                        }
                    @endphp
                    <option value="{{$key}}" {{$selected}}>{{trim($value)}}</option>
                @endforeach
            </select>
            <label class="label-active-force">{{$row->display_name}}</label>
            @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $row->field])
        @endif
    </div>
</div>

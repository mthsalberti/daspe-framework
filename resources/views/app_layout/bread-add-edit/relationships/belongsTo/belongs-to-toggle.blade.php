@php
    $chosenId = 0;
    if ($modelInstance->{$field->apiName} != null){
        $chosenId = $modelInstance->{$field->apiName}->id;
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <select class="mdb-select colorful-select dropdown-primary mt-2" name="{{$field->apiName}}"  id="{{$field->apiName}}">
            <option value="" disabled selected>opções</option>
            @foreach($field->getOptionWhenToggle($modelInstance) as $option)
                @php
                    $selected = '';
                    if(old($field->apiName) == ''){
                        if($option->id == $chosenId){
                            $selected = 'selected';
                        }else if($field->isFirstDefault && $loop->iteration == 1){
                            $selected = 'selected';
                        }
                    }else{
                        if ($option->id == old($field->apiName)){
                            $selected = 'selected';
                        }
                    }
                @endphp
                <option value="{{ $option->id }}"
                        {{--@if(!$create && in_array($option->id, $selectedIdArray)) selected @endif--}}
                {{ $selected }}>@foreach($field->fieldsToShowOnInput as $fieldToShowAux){{ $option->{$fieldToShowAux} }} @endforeach</option>
            @endforeach
        </select>
        <label class="label-active-force">{{$field->label}}</label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>

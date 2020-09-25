@php
    $selectedIdArray = [];
    if (!$create){
        $selectedIdArray = $modelInstance->{$field->method}->pluck("id");
        $selectedIdArray = $selectedIdArray->all();
    }
@endphp
<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <select class="mdb-select colorful-select dropdown-primary mt-2" name="{{$field->apiName}}[]"  id="{{$field->apiName}} " multiple>
            <option value="" disabled selected>opções</option>
            @foreach($modelInstance->{$field->method}()->getModel()::all() as $option)
                <option value="{{ $option->id }}"
                        @if(!$create && in_array($option->id, $selectedIdArray)) selected @endif
                >@foreach($field->fieldsToShow as $fieldToShowAux){{ $option->{$fieldToShowAux} }} @endforeach</option>
            @endforeach
        </select>
        <label class="label-active-force">{{$field->label}}</label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>

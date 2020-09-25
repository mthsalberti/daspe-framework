<div class="col-12 col-md-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @php
            $realValue = '';
            $oldValue = old($field->apiName);
            $persistedValue = $modelInstance->{$field->apiName};
            if ($oldValue != null){
                $realValue = $oldValue;
            }else if($persistedValue != null && $persistedValue instanceof \Carbon\Carbon){
                $realValue = $persistedValue->format('d/m/Y');
            }else if($persistedValue != null){
                $realValue = \Carbon\Carbon::parse($persistedValue)->format('d/m/Y') ;
            }
        @endphp
        <input autocomplete="off" {{$field->readonlyHTML ? 'readonly': ''}}  name="{{$field->apiName}}" type="text" id="{{$field->apiName}}" class="form-control datepicker" value="{{$realValue}}">

        <label for="{{$field->apiName}}" class="active label-active-force">{{$field->label}} </label>
        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
    </div>
</div>

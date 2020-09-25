@php $value = $modelInstance->{$field->apiName}; @endphp
<div class="form-check p-0 m-0">
    <input type="checkbox"
           class="form-check-input form-check-input p-0 m-0"
           id="browse_field_{{$field->apiName}}check_{{$modelInstance->id}}"
           @if($value == 1 || $value === 'on') checked @endif
           disabled>
    <label class="form-check-label" for="browse_field_{{$field->apiName}}check_{{$modelInstance->id}}" style="max-height: 15px;">@if($value == 88) {{$value}} checked @endif</label>
</div>

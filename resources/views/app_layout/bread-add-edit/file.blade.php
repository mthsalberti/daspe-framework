@php
    $file = json_decode($modelInstance->{$field->apiName}, true);
@endphp
<div class="col-3 mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <div class="">
            @if(!$create && $file != '')
                <input type="file" id="{{$field->apiName}}" name="{{$field->apiName}}" class="" data-default-file="{{\Storage::disk(config('filesystems.cloud'))->url($file)}}" />
            @else
                <input type="file" id="{{$field->apiName}}" name="{{$field->apiName}}" class="" />
            @endif

        </div>
    </div>
</div>
<script>

</script>
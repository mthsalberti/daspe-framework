<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        <input type="text" name="{{$field->apiName}}" id="{{$field->apiName}}" class="form-control "
               value="https://{{$modelInstance->{$field->apiName} }}.soumodelo.com.br" readonly>
        <label class="active label-active-force" for="{{$field->apiName}}"
               style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>

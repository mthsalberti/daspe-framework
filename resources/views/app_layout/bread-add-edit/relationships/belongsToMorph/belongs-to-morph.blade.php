<div class="{{$field->width}} m-0 p-0 morph-belongs-to-container">
    <div class="row m-0 p-0">
        <div class="col-12 col-md-6 m-0 p-0">
            <div class="col-12 mb-3 d-flex align-items-stretch">
                <div class="md-form form-sm w-100">
                    <select class="mdb-select colorful-select dropdown-primary mt-2 morph-belongs-to"
                            name="{{$field->makeInputName()}}"
                            id="{{$field->makeInputName()}}">
                        @foreach($belongsToArr as $belongsTo)
                            <option value="{{$belongsTo->method}}" {{$loop->iteration == 1 ? 'selected' : ''}}>{{$belongsTo->label}}</option>
                        @endforeach
                    </select>
                    <label class="label-active-force">{{$field->label}}</label>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 m-0 p-0 ">
            @foreach($belongsToArr as $belongsTo)
                <div class="{{$loop->iteration == 1 ? 'd-block': 'd-none'}} morph-belongs-to-inputs"  data-method="{{$belongsTo->method}}">
                    @include('daspeweb::app_layout.bread-add-edit.relationships.belongsTo.belongs-to', ['field' => $belongsTo, 'modelInstance' => $modelInstance, 'create' => true])
                </div>
            @endforeach
        </div>
    </div>
</div>

@section('javascript')
@parent
<script>
    $(document).ready(function () {
        $('select[class*=morph-belongs-to]').on('change', function () {
            let selectEle = $(this);
            let method = selectEle.val();
            selectEle.closest('.morph-belongs-to-container').find('.morph-belongs-to-inputs').removeClass('d-block').addClass('d-none');
            selectEle.closest('.morph-belongs-to-container').find(`div[data-method=${method}]`).addClass('d-block');
        });
    });

</script>
@endsection

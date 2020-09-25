@if(!$create)
    @php
        $urlDefault = $modelInstance->{$field->apiName};
        $urlFinal = '';
        preg_match ('/(.*)([.])(.*)/', $modelInstance->{$field->apiName}, $matches);
        if (count($matches) >= 3){
            $urlFinal = $matches[1] . '-low.'. $matches[3];
            if (!\Storage::disk('public')->exists($urlFinal)){
                $urlFinal = $urlDefault;
            }
            if (!\Storage::disk('public')->exists($urlFinal)){
                $urlFinal = '';
            }
        }

    @endphp
@endif
<div class="{{$field->width}} mb-3 d-flex align-items-stretch img-controller">
    <div class="row m-0 p-0 w-100">
        <div class="{{(!$create && $urlFinal == '') ? 'col-12' : 'col-6'}} m-0 p-0 img-controller-input-area">
            <div class="md-form form-sm w-100">
                <div class="file-field" style="border-bottom: 1px solid #bdbdbd;">
                    <div class="btn-floating btn-sm cyan darken-2 mt-0 float-right ml-0">
                        <i class="far fa-image" aria-hidden="true"></i>
                        <input type="file" name="{{$field->apiName}}" id="{{$field->apiName}}" accept="image/x-png,image/gif,image/jpeg,image/jpg/*;capture=camera">
                        {{--<input type="hidden" name="snapshot_{{$field->apiName}}" id="snapshot_{{$field->apiName}}">--}}
                    </div>
                    {{--<div class="btn-floating btn-sm cyan darken-2 mt-0 float-right ml-0">--}}
                    {{--<i class="fas fa-camera"></i>--}}
                    {{--<input type="file" class="webcam-snapshot">--}}
                    {{--</div>--}}
                    <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
                    <div class="file-path-wrapper">
                        <input class="file-path file-path-image" type="text" readonly>
                        @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $field->apiName])
                    </div>
                </div>
            </div>
        </div>
        @if(!$create && $urlFinal != '')
            <div class="col-6 m-0 p-0 img-controller-img-area">
                <div class="row m-0 p-0 img-area" style="height: 40px">
                    <input type="hidden" class="img-aux" name="{{$field->apiName}}_aux" value="{{$urlDefault}}" >
                    <div class="col-9 p-0 m-0 pl-1">
                        <img style="max-height: 100%" src="{{$urlFinal}}" alt="">
                    </div>
                    <div  class="col-3 p-0 m-0 my-auto">
                        <button title="Excluir imagem" class="transparent border-0 delete-image"><i class="far fa-trash-alt red-text"></i></button>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>

@section('javascript')
    @parent
    <script>
        $(document).ready(function () {
            $('.file-path-image').on('change', function (event) {
                handleImgChange($(this), event);
            });
            $('.delete-image').on('click', function (event) {
                handleImgChange($(this), event);
            });
        });
        function handleImgChange(ele, event){
            event.preventDefault();
            $(ele).closest('.img-controller').find('.img-aux').val('');
            $(ele).closest('.img-controller').find('img').remove();
            $(ele).closest('.img-controller').find('.img-controller-img-area').hide();
            $(ele).closest('.img-controller').find('.img-controller-input-area').removeClass('col-6').addClass('col-12');
        }
    </script>
@endsection

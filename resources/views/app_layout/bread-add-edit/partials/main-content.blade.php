<section>
    <form id="{{isset($formId) ? $formId : ''}}" data-slug="{{\Daspeweb\Framework\DaspewebHelper::slug()}}" action="{{ $create ? "/admin/".$slug : "/admin/".$slug."/".$modelInstance->id."" }}" method="post" enctype="multipart/form-data" >
        @if(!$create)
            @method('put')
            <input type="hidden" value="{{$modelInstance->id}}" name="id">
        @endif
        @csrf
        <div class="card mt-2">
            <div class="card blue-gradient py-2 mx-sm-1 mx-md-4 mb-3" style="margin-top: -14px;">
                <div class=" mx-4 d-flex justify-content-between">
                    @php
                        $modelInfo = \Daspeweb\Framework\DaspewebHelper::info($slug);
                        $singularName = $modelInfo <> null ? $modelInfo->singular_name : '';
                    @endphp
                    <a href="" class="white-text mx-sm-0 mx-md-3 ">{{ $edit ? 'Editando ' : 'Criando ' }} {{$singularName}}</a>
                    <div class="row m-0 p-0">
                        <div class="col-12 col-md-6 m-0 p-0">
                            <a href="{{\URL::previous()}}" data-dismiss="modal" aria-label="Close" class="btn btn-outline-white btn-rounded btn-sm  waves-effect waves-light py-1 m-0 d-flex  ">
                                <i class="fas fa-save pr-1"></i> Cancelar</a>
                        </div>
                        <div class="col-12 col-md-6 m-0 p-0">
                            <button type="submit" class="btn btn-outline-white btn-rounded btn-sm  waves-effect waves-light py-1 m-0 col-12 d-flex ">
                                <i class="fas fa-save pr-1"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @php $fieldColl = $create ? $modelRaw::fieldsForAddView() : $modelRaw::fieldsForEditView() @endphp
                    @foreach($fieldColl as $field)
                        @if($field->breakUp) <div class="col-12"></div> @endif
                        @if($create)
                            {!! $field->renderAddView($modelInstance) !!}
                        @else
                            {!! $field->renderEditView($modelInstance) !!}
                        @endif
                        @if($field->breakDown) <div class="col-12"></div> @endif
                    @endforeach
                </div>
                @yield('injection-area')
            </div>
        </div>
    </form>
    @if ($errors->any())
        <div class="my-3">
            <div class="alert alert-danger my-2">
                <ul class="m-0">
                    @php $errorPrinted =[]; @endphp
                    @foreach ($errors->all() as $error)
                        @if(array_has($errorPrinted, $error)) @continue @endif
                        @php $errorPrinted[$error] = 1; @endphp
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</section>

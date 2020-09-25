@php
    $fieldToSelectOriginal = [];
    $loadAll = false;
    if (request()->has('fields_to_select')){
        $fieldToSelectOriginal = json_decode(request()->input('fields_to_select'));
    }
    if(count($fieldToSelectOriginal) == 1){
        $loadAll = true;
    }

    $fieldListToLoad = $is_related_list || $loadAll
        ? \Daspeweb\Framework\DaspewebHelper::getModelBySlug($slug)::fields()
        : \Daspeweb\Framework\DaspewebHelper::getModelBySlug($slug)::fieldsForBrowseView();
    if(!$loadAll && $is_related_list){
        $fieldListToLoad = $fieldListToLoad->filter(function ($item) use ($fieldToSelectOriginal){
            return in_array($item->apiName, $fieldToSelectOriginal);
        });
    }
    $sumBtn = 0;

@endphp

<div class="row m-0 p-0 browse-card-version">
    @foreach($dataTypeContent as $data)@php $modelInstance = $data;@endphp
    <div class="col-12 col-md-4 col-lg-3 mb-2 px-2 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body py-3 px-2">
                <ul class="list-group">
                    {{--{{dd($fieldListToLoad)}}--}}
                    @foreach($fieldListToLoad as $field)
                        @if(get_class($field) == 'Daspeweb\Framework\Field\Image')
                            @php
                                $imgCollJson = json_decode($modelInstance->{$field->apiName}, true);
                                if(count($imgCollJson) == 0){
                                    $imgCollJson[0] = [
                                        'path-low' => '',
                                        'path' => '',
                                        'width' => '',
                                        'height' => '',
                                    ];
                                }
                            @endphp
                            <div class="z-depth-2 mb-3" style="margin-top: -25px;">
                                <img src="{{\Storage::disk('gcs')->url($imgCollJson[0]['path-low'])}}" class=" pt-1 w-100" >
                            </div>
                        @endif
                    @endforeach

                    @foreach($fieldListToLoad as $field)
                        @if(get_class($field) != 'Daspeweb\Framework\Field\Image')
                            <li class="list-group-item border-left-0 border-right-0 px-1 py-1">
                                <span class="grey-text">{{$field->label}}:</span>
                                <br>
                                <div class="float-left">
                                    {!! $field->renderBrowseView($modelInstance) !!}
                                </div>
                            </li>
                        @endif

                    @endforeach
                </ul>

            </div>

            <div class="btn-group d-flex m-2 z-depth-1 rounded" role="group" >
                @if($canRead)
                    <a href="/admin/{{$slug}}/{{$modelInstance->id}}" title="Ver" class="w-100 py-1 px-2 btn btn-outline-white btn-rounded waves-effect no-box-shadow" style="color: #007bff!important;">
                        <i class="fas fa-eye pr-1"></i>
                    </a>
                @endif
                @if($canEdit)
                    <a href="/admin/{{$slug}}/{{$modelInstance->id}}/edit" title="Editar" class="w-100 py-1 px-2 btn btn-outline-white btn-rounded waves-effect no-box-shadow edit" style="color: #007bff!important;">
                        <i class="fas fa-edit pr-1"></i>
                    </a>
                @endif
                @if($canDelete)
                    <a href="javascript:;" title="Excluir" class="w-100 py-1 px-2 btn btn-outline-white btn-rounded waves-effect no-box-shadow delete-modal {{$is_related_list ? 'is-related-list' : '' }}"
                       data-id="{{ $data->id }}"
                       data-url="/admin/{{$slug}}"
                       style="color: #007bff!important;">
                        <i class="fas fa-trash pr-1 red-text"></i>
                    </a>
                @endif

                @if(method_exists($modelInstance, 'extraActions'))
                    @if($sumBtn <= 1)
                        {{--@foreach($modelInstance->extraActions() as $action)--}}
                        {{--@if($action->onBrowseView && $action->checkCriteria($modelInstance))--}}
                        {{--<a href="{{$action->makeLink($modelInstance)}}"--}}
                        {{--title="{{$action->name}}"--}}
                        {{--data-id="{{$modelInstance->id}}"--}}
                        {{--class="w-100 py-1 px-2 btn btn-outline-white btn-rounded waves-effect no-box-shadow--}}
                        {{--{{$action->makeCssClass()}} {{$action->extraClass}}">--}}
                        {{--{!! $action->icon !!} {{$action->name}}--}}
                        {{--</a>--}}
                        {{--@endif--}}
                        {{--@endforeach--}}
                    @else
                        {{--<button id="extraactiondrop{{$loop->iteration}}" type="button" class="w-100 py-1  px-0 btn btn-outline-light btn-rounded waves-effect"--}}
                        {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 60px !important;color: #007bff!important;" >--}}
                        {{--<i class="fas fa-ellipsis-v" ></i>--}}
                        {{--</button>--}}
                        {{--<div class="dropdown-menu" aria-labelledby="extraactiondrop{{$loop->iteration}}">--}}
                        {{--@foreach($modelInstance->extraActions() as $action)--}}
                        {{--@if($action->onBrowseView && $action->checkCriteria($modelInstance))--}}
                        {{--<a href="{{$action->makeLink($modelInstance)}}"--}}
                        {{--style="text-transform: unset !important; padding: 2px 8px 2px 8px !important;"--}}
                        {{--title="{{$action->name}}"--}}
                        {{--data-id="{{$modelInstance->id}}"--}}
                        {{--class="dropdown-item {{$action->makeCssClass()}} ">--}}
                        {{--{!! $action->icon !!} {{$action->name}}--}}
                        {{--</a>--}}
                        {{--@endif--}}
                        {{--@endforeach--}}
                        {{--</div>--}}
                    @endif
                @endif

            </div>
        </div>
    </div>
    @endforeach
</div>



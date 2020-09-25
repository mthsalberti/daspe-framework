@extends('daspeweb::master_daspe')
@section('page_header')
@stop

@section('content')
    @php
        $extensionPageCallbacks = [];
        $modelInfo = \Daspeweb\Framework\DaspewebHelper::info(\Daspeweb\Framework\DaspewebHelper::slug());
    @endphp
    @if($canDelete)
        @include('daspeweb::app_layout.partials.delete-modal')
    @endif
    <input type="hidden" id="record-id" value="{{$modelInstance->id}}">
    <input type="hidden" id="record-slug" value="{{\Daspeweb\Framework\DaspewebHelper::slug()}}">
    <div class="row" style="margin: 0; padding: 0;">
        <div class="col-12"  style="margin: 0; padding: 0;">
            <div class="classic-tabs classic-tabs-related w-100 " >
                <div class="w-100 position-absolute nav-overflow-icons ">
                    <a href="" class="btn-floating btn-sm white mt-1 mr-1 left-to-related">
                        <i class="fas fa-chevron-left blue-text "></i>
                    </a>
                    <a href="" class="btn-floating btn-sm white mt-1 ml-1 right-to-related">
                        <i class="fas fa-chevron-right blue-text "></i>
                    </a>
                </div>
                <ul class="nav odonto-admin-bg scrollbar-related" role="tablist" >
                    <li class="nav-item">
                        <a class="nav-link waves-light  {{ request()->input('tab') == "" || request()->input('tab') == null  ? 'active' : '' }}"
                           data-toggle="tab" href="#main-panel" role="tab">
                            <span class="pl-2"><i style="font-size: 1rem;" class="{{$modelInfo->icon}} pr-1"></i>{{$modelInfo->singular_name}}</span></a>
                    </li>
                    @if(method_exists($modelRaw, 'relatedLists'))
                        @foreach($modelRaw::relatedLists() as $key => $relatedList)
                            @php
                                $relatedListModel = \Daspeweb\Framework\DaspewebHelper::infoByNamespace($relatedList->model);
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link waves-light related-tab
                                    {{request()->input('tab') == $relatedListModel->slug ? 'active' : ''}}"
                                   data-toggle="tab"
                                   data-tab-name="{{$relatedListModel->slug}}"
                                   href="#related-data-panel-{{$key}}" role="tab">
                                    <span class="pl-2"><i style="font-size: 1rem;" class="{{ $relatedList->icon ?? $relatedListModel->icon}}"></i>
                                        {{$relatedList->label ?? $relatedListModel->plural_name}}</span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                    @if(method_exists($modelRaw, 'extensionPages'))
                        @foreach($modelRaw::extensionPages() as $key => $extensionPage)
                            @php $extensionPageCallbacks[] = $extensionPage->callbackName; @endphp
                            <li class="nav-item">
                                <a class="nav-link waves-light related-tab {{request()->input('tab') == $extensionPage->tabName ? 'active' : ''}}"
                                   data-toggle="tab"
                                   data-tab-name="{{$extensionPage->tabName}}"
                                   href="#extension-page-data-panel-{{$key}}" role="tab">
                                    <span class="pl-2"> <i style="font-size: 1rem;" class="{{$extensionPage->icon}}"></i> {{$extensionPage->label}}</span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-12 " style="margin: 0; padding: 0;">
            <div class="card pt-2 tab-content  mb-5">
                <!--Panel 1-->
                <div class="tab-pane fade {{ request()->input('tab') == "" || request()->input('tab') == null ? 'in show active' : '' }} " id="main-panel" role="tabpanel">
                    <div class="col-12 m-0 p-0">
                        <div class="d-flex pr-2 actions border-0 py-1 py-md-0" >
                            <div class="m-auto">
                                <div class="btn-group" role="group" aria-label="Ações">
                                    @if(method_exists($modelRaw, 'extraActions'))
                                        @foreach($modelRaw::extraActions() as $action)
                                            @if(!$action->onReadView || !$action->checkCriteria($modelInstance)) @continue @endif
                                            <a href="{{$action->makeLink($modelInstance)}}"
                                               target="{{$action->target}}"
                                               data-id="{{$modelInstance->id}}"
                                               type="button"
                                               class="btn btn-sm btn-outline-primary btn-rounded waves-effect {{$action->extraClass}}">
                                                {!! $action->icon !!} <span class="pl-2">{{$action->name}}</span>
                                            </a>
                                        @endforeach
                                    @endif
                                    @if($canAdd)
                                        <a href="/admin/{{\Daspeweb\Framework\DaspewebHelper::slug()}}/create" type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effect ">{{$modelInfo->add_new_label}}</a>
                                    @endif
                                    @if($canEdit)
                                        <a href="/admin/{{\Daspeweb\Framework\DaspewebHelper::slug()}}/{{$modelInstance->id}}/edit" type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effect main-edit-button"> {{$modelInfo->edit_label}}</a>
                                    @endif
                                    @if($canDelete)
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effect delete-modal"
                                                data-id="{{ $modelInstance->id }}" data-url="/admin/{{\Daspeweb\Framework\DaspewebHelper::slug()}}"> {{$modelInfo->delete_label}}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <div class="row">
                            @php
                                $temRichtext = false;
                                $temHora = false;
                                $temData = false;
                            @endphp
                            @foreach(\Daspeweb\Framework\DaspewebHelper::getModelBySlug(\Daspeweb\Framework\DaspewebHelper::slug())::fieldsForReadView() as $field)
                                @if($field->breakUp) <div class="col-12"></div> @endif
                                {!!  $field->renderReadView($modelInstance) !!}
                                @if($field->breakDown) <div class="col-12"></div> @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @if(method_exists($modelInstance, 'relatedLists'))
                    @foreach($modelInstance->relatedLists() as $key => $relatedList)
                        @php
                            $relatedListModelInfo = \Daspeweb\Framework\DaspewebHelper::infoByNamespace($relatedList->model);
                        @endphp
                        <div class="tab-pane fade {{request()->input('tab') == $relatedListModelInfo->slug ? 'in show active' : ''}}"
                             id="related-data-panel-{{$key}}" role="tabpanel">
                            @include('daspeweb::app_layout.related-list.related-list',
                            ['modelInfo' => $modelInfo, 'modelInstance' => $modelInstance, 'relatedList' => $relatedList, 'relatedListModelInfo' => $relatedListModelInfo])
                        </div>
                    @endforeach
                @endif
                @if(method_exists($modelInstance, 'extensionPages'))
                    @foreach($modelInstance->extensionPages() as $key => $extensionPage)
                        <div class="tab-pane fade {{request()->input('tab') == $extensionPage->tabName ? 'in show active' : ''}}"
                             id="extension-page-data-panel-{{$key}}" role="tabpanel">
                            @include($extensionPage->path, ['extensionPage' => $extensionPage])
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('a.right-to-related').on('click', function (e) {
            e.preventDefault();
            document.querySelector('.scrollbar-related').scrollBy(160,0);
        });
        $('a.left-to-related').on('click', function (e) {
            e.preventDefault();
            document.querySelector('.scrollbar-related').scrollBy(-800,0);
        });
        $('input').on('dblclick', function () {
            let editBtnEle = $('.main-edit-button').eq(0);
            if (editBtnEle){
                window.location.href = editBtnEle.attr('href')
            }
        });
        let functionToListenAfterRerender = [];
        window.onload =function () {
            $.each($("[id*=main-for-ajax-only-render-this-section-]"), function (index, section) {
                section = $(section);
                renderPagination(1, section );
            });
            loadPageListeners();
            @foreach($extensionPageCallbacks as $extensionPageCallback)
            @if($extensionPageCallback <> '')
                try{
                    {{$extensionPageCallback . "();"}}
                }    catch(e){}
            @endif
            @endforeach
        }

        async function renderPagination(page = 1, section) {
            let resource = section.data("related-list");
            let fields = $(`input[name=fields-for-${resource}]`).val();

            section.find(".for-ajax-only-render-this-section-content").removeClass('daspe-transparent');
            $('.daspe-transparent').each(function (index, val) {
                $(val).removeClass('daspe-transparent');
            });
            params = {};
            params['render-ajax'] = 'true';
            params['fields_to_select'] = fields;
            params['is_related_list'] = true;
            params['use-card-layout'] = section.attr('data-use-card-layout');
            params['page'] = page;
            params['filter-'+section.data('fk')] = section.data('fk-id');
            $.ajax({
                url: '/admin/'+resource,
                method: "get",
                dataType: "html",
                data : params,
                error: function (xhr, ajaxOptions, thrownError) {
                    // $('#search-form').submit();
                },
                success: function (output, status, xhr) {
                    $('#main-for-ajax-only-render-this-section-'+resource + ' div').remove();
                    $('#main-for-ajax-only-render-this-section-'+resource).append(output);
                    fixPageLinksAjax();
                },

            }).done(function(data, b, c, d) {
                // loadPageListeners();
            });
        }

        function fixPageLinksAjax() {
            $('.pagination .page-link').on('click', function (event) {
                event.stopPropagation();
                event.preventDefault();
                let aEle = $(this);
                let href = String(aEle.attr('href'));
                let page = new URL(aEle.attr('href')).searchParams.get('page');
                let section = aEle.closest('[id*=main-for-ajax-only-render-this-section-');
                renderPagination(page, section);
            });
        }

        function loadPageListeners(){
            initPhotoSwipeFromDOM('.mdb-lightbox');
        }

        function loadMode(that){
            $('#modal-neutral-body').empty();
            $('#modal-neutral-header').children().show();
            $('#modalLoginAvatarDemo').modal();
            let varCtl = {
                slug : $(that).data('slug'),
                field : $(that).data('field'),
                id : $(that).data('id')
            }
            $.ajax({
                url: `/admin/${varCtl.slug}/${varCtl.id}/get-field/${varCtl.field}`,
                method: "get",
                dataType: "html",
                error: function (xhr, ajaxOptions, thrownError) {
                },
                success: function (output, status, xhr) {
                    if(output == '') output = '<h1>Conteúdo vazio<h1>';
                    $('#modal-neutral-header').children().fadeOut();
                    $('#modal-neutral-body').append(output);
                }
            }).done(function(data, b, c, d) {
                loadPageListeners();
            });
        }


    </script>
    @if(view()->exists('app_layout.'.\Daspeweb\Framework\DaspewebHelper::slug().'.scripts.read'))
        @include('app_layout.'.\Daspeweb\Framework\DaspewebHelper::slug().'.scripts.read')
    @endif
@stop




@extends('daspeweb::master_daspe')
@section('content')
    <section >
        <form action="/admin/{{$slug}}" method="get" id="search-form" onsubmit="event.preventDefault();">
            @if(!$modelRaw->hideViewMode)
            <div class="card p-2 mb-4">
                <div class="row m-0 p-0">
                    <div class="col-12 col-md-6">
                        <select class="mdb-select colorful-select dropdown-primary w-100 " name="view_id">
                            <option value="todos">Todos</option>
                            @foreach($listViewColl as $listView)
                                <option value="{{$listView->id}}" @if(request()->input('view_id') == $listView->id) selected @endif>{{$listView->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                    <div class="d-flex">
                        <input class="form-control my-0 py-0" type="text" placeholder="Procurar..."
                               name="value-to-search"  id="value-to-search" value="{{request()->input('value-to-search')}}" >
                        <button type="submit" id="search-form-submit" class="btn btn-sm btn-primary ml-2 px-3" style="margin-top: 4px !important;">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                </div>
            </div>
            @endif
            <input type="hidden" name="page" id="paginator" value="{{request()->input('page')}}">
            <input type="hidden" name="sort-by" id="sort-by" value="{{request()->input('sort-by')}}">
            <input type="hidden" name="sort-by-order" id="sort-by-order" value="{{request()->input('sort-by-order')}}">
        </form>

        <div class="card card-cascade narrower z-depth-1">
            @if($canAdd || $canDelete)
            <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-1 mx-md-4 mb-3 d-flex justify-content-between align-items-center">
                <a href="" class="white-text mx-3"><i class="{{\Daspeweb\Framework\DaspewebHelper::getModelBySlug($slug)->icon}}"></i>
                    {{--{{dd(\Daspeweb\Framework\DaspewebHelper::info($slug))}}--}}
                    {{\Daspeweb\Framework\DaspewebHelper::info($slug)->singular_name}}</a>
                <div class="d-block">
                    @if($canDelete)
                        <a type="button" class="btn btn-outline-white btn-rounded btn-sm p-1 m-0" id="bulk_delete_btn"
                           data-url="/admin/{{$slug}}"><i class="fas fa-trash p-0 m-0"></i> exclusão</a>
                    @endif
                    @if($canAdd)
                        <a href="/admin/{{$slug}}/create" class="btn btn-outline-white btn-rounded btn-sm p-1 m-0" ><i class="fas fa-plus p-0 m-0"></i> adicionar</a>
                    @endif

                        <button class="btn btn-outline-white btn-rounded btn-sm p-1 m-0 modal-filter"  data-toggle="modal" data-target="#modal-filter"><i class="fas fa-filter p-0 m-0"></i> filtrar</button>

                    @if(method_exists($modelRaw, 'modelActions'))
                        @foreach($modelRaw::modelActions() as $key => $modelAction)
                            @if($modelAction->onModelMainPage)
                                <a href="#" class="btn btn-outline-white btn-rounded btn-sm p-1 m-0" >{{$modelAction->name}}</a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @endif
            <div class="px-md-4 px-sm-1 py-2" id="for-ajax-only-render-this-section" style="margin-top: -5px;">
                @include('daspeweb::bread.browse-ajax')
            </div>
        </div>

    </section>


    {{--modal para inserir filtros--}}
    @include('daspeweb::bread.partials.browse.filter-modal')
    {{--fim modal para inserir filtros--}}
@stop

@section('css')
@stop


@section('javascript')
    @include('daspeweb::bread.browse-js')
    @if(view()->exists('app_layout.'.$slug.'.scripts.browse'))
        @include('app_layout.'.$slug.'.scripts.browse')
    @endif

@stop

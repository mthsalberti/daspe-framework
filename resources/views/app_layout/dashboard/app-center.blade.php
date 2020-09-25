@extends('daspeweb::master_daspe')

@section('content')
    @foreach($grouped as $key => $dwModelColl)
        @php
            $boxCounter = 0;
            foreach($dwModelColl as $dwModel){
                if($dwModel->is_displayed_on_app_center == 0)continue;
                if(!\Daspeweb\Framework\CheckPermission::hasPermissionForThisModel('B', $dwModel->slug))continue;
                $boxCounter ++;
            }
        @endphp
        @if($boxCounter == 0) @continue @endif
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="px-2">{{$key}}</h5>
                <div class="row m-0 p-0">
                    @foreach($dwModelColl->sortBy('order') as $dwModel)
                        @if($dwModel->is_displayed_on_app_center == 0) @continue @endif
                            @if(!\Daspeweb\Framework\CheckPermission::hasPermissionForThisModel('B', $dwModel->slug)) @continue @endif
                        <div class="col-12 col-md-4 mb-2 px-2 mx-0">
                            <div class="card promoting-card">
                                <div class="card-body pb-2  d-flex flex-row">
                                    <i class="fa-3x text-primary pr-2 {{$dwModel->icon == '' ? 'fas fa-atom' : $dwModel->icon }}"></i>
                                    <div>
                                        <h6 class="card-title font-weight-bold mb-2">
                                            {{$dwModel->plural_name}}</h6>
                                        <p class="card-text mb-0">
                                            registros: {{\Cache::get('model-count-'.$dwModel->slug, app($dwModel->namespace)::count(), 60*4)}}</p>
                                    </div>
                                </div>
                                <div class="card-body px-0 pb-3 py-1 mx-auto">
                                    <div class="btn-group btn-group-sm " role="group" aria-label="Basic example">
                                        <a href="/admin/{{$dwModel->slug}}/create" class="btn btn-primary btn-sm">novo</a>
                                        <a href="/admin/{{$dwModel->slug}}" class="btn btn-primary btn-sm">todos</a>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button"
                                                    class="btn btn-primary  py-0 px-2 " data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu"
                                                 style="will-change: transform;top: 44px;left: 0px;
                                                 transform: translate3d(0px, -306px, 0px);
                                                 max-height: 409px;overflow-y: scroll;"
                                                 aria-labelledby="btnGroupDrop-{{$dwModel->id}}">
                                                <a class="dropdown-item" href="#">ver todos</a>

                                                @php
                                                    $listViewColl = \App\ListView::orderBy('name')
                                                    ->where('dw_model_id', $dwModel->id)
                                                    ->where(function ($query){
                                                        $query->orWhere(function ($query){
                                                            $query->whereIsOnlyForMe(true);
                                                            $query->where('user_id', Auth::user()->id);
                                                        });
                                                        $query->orWhere(function ($query){
                                                           $query->where('is_only_for_me', '');
                                                        });
                                                    })->get();
                                                @endphp
                                                @foreach($listViewColl as $listView)
                                                    <a class="dropdown-item" href="/admin/{{$dwModel->slug}}?view_id={{$listView->id}}">{{$listView->name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

@endsection

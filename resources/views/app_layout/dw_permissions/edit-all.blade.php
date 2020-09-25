@extends('daspeweb::master_daspe')

@section('content')
    <form action="/admin/custom/permission-control/all" method="post">

        @csrf
        @foreach($permissionByModelNameMap as $modelName => $permissionByModelNameColl)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">{{ $modelName}}</h5>
                    <table class="table table-bordered">
                        <thead>
                        <tr class="py-1">
                            <th class="py-1"><strong>Perfil</strong></th>
                            @foreach($permissionByModelNameColl as $permName => $permByRoleColl)
                                <th class="text-center py-1">{{$permName}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="py-1">{{$role->name}}</td>
                                @foreach($permissionByModelNameColl as $permName => $permByRoleColl)
                                    <td class="py-1">
                                        <div class="form-check py-0 m-0" style="    line-height: 0px !important; text-align: -webkit-center;max-height: 10px !important;">
                                            <input type="checkbox" checked value="0" name="pdr-{{$permByRoleColl[$role->name][0]->id}}">
                                            <input type="checkbox" class="form-check-input py-0 m-0"
                                                   id="pdr-{{$permByRoleColl[$role->name][0]->id}}"
                                                   name="pdr-{{$permByRoleColl[$role->name][0]->id}}"
                                                   value="1"
                                                   @if($permByRoleColl[$role->name][0]->is_allowed) CHECKED @endif>
                                            <label class="form-check-label py-0 m-0" for="pdr-{{$permByRoleColl[$role->name][0]->id}}"></label>

                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        @endforeach
        <div class="card my-1 mb-3">
            <div class="card-body">
                <button class="btn btn-sm btn-primary">salvar</button>
            </div>
        </div>
    </form>
@endsection

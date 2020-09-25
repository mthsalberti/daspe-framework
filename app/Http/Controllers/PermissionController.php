<?php

namespace Daspeweb\Framework\Controller;

use App\DwModel;
use App\DwPermissionDetail;
use App\DwPermissionDetailRole;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function loadAll(){
        if(Auth::user()->role_id <> 1){
            abort(401);
        }
//        Artisan::call('daspeweb:permissions');
        $models = DwModel::orderBy('slug')
            ->with('dwPermissionDetail')
            ->get();

        $roles = Role::all();

        $dwPermissionDetailRoleColl = DwPermissionDetailRole
            ::with('role')
            ->with('dwPermissionDetail.model')
            ->get();
        $dwPermissionDetailRoleMap = $dwPermissionDetailRoleColl->map(function ($dwPermissionDetailRole){
            $dwPermissionDetailRole->role_name = $dwPermissionDetailRole->role->name;
            $dwPermissionDetailRole->permission_name = $dwPermissionDetailRole->dwPermissionDetail->permission_name;
            $dwPermissionDetailRole->dw_model_id = $dwPermissionDetailRole->dwPermissionDetail->dw_model_id;
            $dwPermissionDetailRole->dw_model_name = $dwPermissionDetailRole->dwPermissionDetail->model->name;
            return $dwPermissionDetailRole;
        });
        $permissionByModelNameMap = $dwPermissionDetailRoleMap->groupBy('dw_model_name');
        foreach ($permissionByModelNameMap as $key => $permissionByModelName){
            $permissionByModelName = $permissionByModelName->groupBy('permission_name');
            $permissionByModelNameMap[$key] = $permissionByModelName;
            foreach ($permissionByModelNameMap[$key] as $keyRole => $role){
                $roleGroupedByRoleName = $role->groupBy('role_name');
                $permissionByModelNameMap[$key][$keyRole] = $roleGroupedByRoleName;
            }
        }
        return view('daspeweb::app_layout.dw_permissions.edit-all')
            ->with('roles', $roles)
            ->with('permissionByModelNameMap', $permissionByModelNameMap);
    }

    public function save(){
        if(Auth::user()->role_id <> 1){
            abort(401);
        }
//        dd(request()->all());
        foreach (request()->all() as $inputName => $value){
            if(strpos($inputName, 'pdr')  !== false){
                $id = str_replace("pdr-", "", $inputName);
                $dwPermDetailRole = DwPermissionDetailRole::find($id);
                $dwPermDetailRole->is_allowed = $value;
                $dwPermDetailRole->save();
            }
        }

        $dwPermDetailRoleColl = DwPermissionDetailRole
            ::with('dwPermissionDetail.model')
            ->get();
        foreach($dwPermDetailRoleColl as $dwPermDetailRole){
            $key = 'check-permission.'
                . $dwPermDetailRole->dwPermissionDetail->model->slug .'.'
                . $dwPermDetailRole->dwPermissionDetail->permission_name . '.'
                . Auth::user()->role_id;
            Cache::forget($key);
        }
        return redirect()->back();
    }
}

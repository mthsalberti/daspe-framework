<?php
namespace Daspeweb\Framework;

use App\DwModel;
use App\DwPermissionDetailRole;
use Daspeweb\Framework\Model\ModelNew;
use Illuminate\Support\Facades\Cache;

class DaspewebHelper
{
    public static function breadcrumb($seg){
        $seg = str_replace("daspe.", "", $seg);
        $seg = str_replace("breadcrumb.", "", $seg);
        $seg = str_replace("-", " ", $seg);
        return $seg;
    }

    public static function slug(){
        return \Request::segments()[1];
    }

    public static function getModelBySlug($slug){
        $key = 'slug-'.$slug;
        return Cache::get($key, app(DwModel::whereSlug($slug)->first()->namespace), 60*24);
    }

    public static function infoByNamespace($namespace){
        $key  = 'model-new-info.'.$namespace;
        return Cache::get($key, DwModel::whereNamespace($namespace)->first(), 60*24);
    }

    public static function infoByBaseName($name){
        $key  = 'model-new-info.'.$name;
        return Cache::get($key, DwModel::whereName($name)->first(), 60*24);
    }

    public static function info($slug = null){
        if ($slug == null) $slug = DaspewebHelper::slug();
        $key  = 'model-new-info.'.$slug;
        return Cache::get($key, DwModel::whereSlug($slug)->first(), 60*24);
    }

    public static function clearCache(){
        $permDetailRoleColl = DwPermissionDetailRole::with('dwPermissionDetail.model')->get();
        foreach ($permDetailRoleColl as $permDetailRole){
            $keys = [];
            $keys[] = 'check-permission.'
                . $permDetailRole->dwPermissionDetail->model->slug . '.'
                . $permDetailRole->dwPermissionDetail->permission_name . '.'
                . $permDetailRole->role_id;
            $keys[] = 'slug-'.$permDetailRole->dwPermissionDetail->model->slug;
            $keys[]  = 'model-new-info.'.$permDetailRole->dwPermissionDetail->model->slug;
            $keys[] = 'model-new-info.'.$permDetailRole->dwPermissionDetail->model->name;
            $keys[]  = 'model-new-info.'.$permDetailRole->dwPermissionDetail->model->namespace;
            foreach($keys as $key){
                Cache::forget($key);
            }
        }
    }


}

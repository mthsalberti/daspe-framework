<?php

namespace Daspeweb\Framework;

use App\DwModel;
use App\DwPermissionDetail;
use App\DwPermissionDetailRole;
use Daspeweb\Framework\Model\ModelNew;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckPermission
{
    public static $instance;
    private $roleId;

    public static function getInstance(){
        if (!isset(self::$instance)) {
            $instance = new self();
                $instance->roleId = Auth::user()->role->name_api;
        }
        return $instance;
    }

    public static function check($permission, $slug = null) {
        if (is_null($slug)) $slug = \Daspeweb\Framework\DaspewebHelper::slug();
        if(!self::getInstance()->isAllowedBySlug($permission, $slug)) abort(401);
    }

    public static function hasPermissionForThisModel($permission, $slug) {
        return self::getInstance()->isAllowedBySlug($permission, $slug);
    }

    public static function checkIfAllowedOnlyForOwner($permission, $data, $slug){
        if(!self::isOwner($data, $slug) && self::isRequiredToBeTheOwner($permission, $slug)){
            abort(401);
        }
    }

    private static function isOwner($data, $slug){
        $modelInfo = \Daspeweb\Framework\DaspewebHelper::info($slug);
        $ownerShipFields = explode(",", $modelInfo->ownership_fields);
        foreach ($ownerShipFields as $ownerShipField){
            $ownerShipField = trim($ownerShipField);
            if($ownerShipField == "") return true;
            $valueToCompare = trim($data->$ownerShipField);
            if($valueToCompare == Auth::user()->id){
                return true;
            }
        }
        return false;

    }

    public static function isRequiredToBeTheOwner($permission, $slug){
        return self::getInstance()->isAllowedBySlug($permission . 'TO', $slug);//TO = their own records
    }

    public static function loadOnlyIfOwner($permission, $slug = null){
        return self::getInstance()->isAllowedBySlug($permission . 'TO', $slug);//TO = their own records
    }

    public function isAllowedBySlug($permission, $slug){
        if (is_null($slug)) $slug = \Daspeweb\Framework\DaspewebHelper::slug();

        $key = 'check-permission.'.$slug .'.' . $permission . '.' . Auth::user()->role_id;
        if(!Cache::has($key)){
            $dwModel = DwModel::whereSlug($slug)->first();
            $dwPermDetail = DwPermissionDetail::where('dw_model_id', $dwModel->id)
                ->where('permission_name', $permission)
                ->first();

            $dwPermDetailRole = DwPermissionDetailRole
                ::where('role_id', Auth::user()->role_id)
                ->where('dw_permission_detail_id', $dwPermDetail->id)
                ->first();
            Cache::put($key, $dwPermDetailRole->is_allowed == "1" ? true : false, 24*60);
        }
        return Cache::get($key);
    }
}

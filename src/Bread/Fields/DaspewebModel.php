<?php

namespace Daspeweb\Framework\Field;

use Daspeweb\Framework\DaspewebHelper;
use Illuminate\Support\Facades\Auth;

trait DaspewebModel
{
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $modelInfo = DaspewebHelper::infoByBaseName(class_basename($model));
            if ($modelInfo <> null && $modelInfo->has_owner_field && ($model->user_id == '' || $model->user_id == null)){
                if(Auth::check()){
                  $model->user_id = Auth::user()->id;
                }
            }
        });
    }

    public function getInternalName(){
        $path = explode('\\', self::class);
        return end($path);
    }
    public static function allFields(){
        return self::fields();
    }

    public static function fieldsForBrowseView(){
        return self::fields()->filter(function ($model, $key) {
            return $model->onBrowseView;
        });
    }

    public static function fieldsForReadView(){
        return self::fields()->filter(function ($model, $key) {
            return $model->onReadView;
        });
    }

    public static function fieldsForEditView(){
        return self::fields()->filter(function ($model, $key) {
            return $model->onEditView;
        });
    }

    public static function fieldsForAddView(){
        return self::fields()->filter(function ($model, $key) {
            return $model->onAddView;
        });
    }

    public static function searchableFields(){
        return self::fields()->filter(function ($model, $key) {
            return $model->searchable;
        });
    }

    public static function relationshipFields(){
        $arrAux = collect();

        $a = self::fields()->filter(function ($model, $key) {
            return isset($model->method);
        });

        foreach(self::fields() as $field){
            if(property_exists($field, 'belongsToList')){
                foreach($field->belongsToList as $relationship){
                    $arrAux->push($relationship);
                }
            }
        }
//        dd($arrAux->merge($a));
        return $arrAux->merge($a);
    }


}

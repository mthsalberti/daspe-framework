<?php

namespace Daspeweb\Framework\Controller;

use Carbon\Carbon;
use Daspeweb\Framework\DaspewebHelper;
use Daspeweb\Framework\Model\ModelNew;

trait UpsertData
{
    public function upsertData($slug, $model, $request, $create = true, $id = null){
        $rules = [];
        if ($create){
            foreach (DaspewebHelper::getModelBySlug($slug)::fieldsForAddView() as $field){
                $rules = $this->loadValidations($model, $field, $rules);
            }
        }else{
            $model = $model->find($id);
            foreach (DaspewebHelper::getModelBySlug($slug)::fieldsForEditView() as $field){
                $rules = $this->loadValidations($model, $field, $rules);

            }
        }
        $request->validate($rules);

        if ($create){
            foreach (DaspewebHelper::getModelBySlug($slug)::fieldsForAddView() as $field){
                $field->fillModelInstance($model, request());
            }
        }else{
            $model = $model->find($id);
            foreach (DaspewebHelper::getModelBySlug($slug)::fieldsForEditView() as $field){
                    $field->fillModelInstance($model, request());

            }
        }

        if ($create) $model->created_at = Carbon::now();
        $model->updated_at = Carbon::now();
        return $model;
    }

    public function loadValidations($model, $field, $rules){
        if (method_exists($model, 'validations')){
            if (class_basename($field) == 'ImageCollection'){
                $rules[$field->apiName.'.*'] = array_merge(
                    $field->validateField(),
                    $this->arrayFix($model::validations($model)->get($field->apiName))
                );

            }else{
                $rules[$field->apiName] = array_merge(
                    $field->validateField(),
                    $this->arrayFix($model::validations($model)->get($field->apiName))
                );
            }

        }else{
            if (class_basename($field) == 'ImageCollection'){
                $rules[$field->apiName.'.*'] = $field->validateField();
            }else{
                $rules[$field->apiName] = $field->validateField();
            }
        }
        return $rules;
    }

    function arrayFix($arr){
        if ($arr == null){
            return [];
        }else{
            return $arr;
        }
    }

}

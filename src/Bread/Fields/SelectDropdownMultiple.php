<?php

namespace Daspeweb\Framework\Field;

use Daspeweb\Framework\DaspewebHelper;

class SelectDropdownMultiple extends Field
{
    use DaspewebModel;
    public $internalName = "selectdropdowmultiple";
    public $options;

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;
        return $newInstance;
    }

    public function loadOptionsFromModel($modelPath, $key = 'name', $value = 'name'){
        $coll = app($modelPath)::all();
        $keyed = $coll->mapWithKeys(function ($item) use ($key, $value){
            return [$item[$key] => $item[$value]];
        });
        $this->options = $keyed;
        return $this;
    }

    public function optionList($options){
        $this->options = $options;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.select-multiple', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.select-dropdown-multiple',
            ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.select-dropdown-multiple')
            ->with('field', $this)
            ->with('modelInstance', $modelInstance)
            ->with('modelInstanceAux', $modelInstance)
            ->with('create', true);
    }

    public function renderEditView($modelInstance){
        $viewName = 'daspeweb::app_layout.bread-add-edit.select-dropdown-multiple';
        return view($viewName)
            ->with('field', $this)
            ->with('modelInstance', $modelInstance)
            ->with('modelInstanceAux', $modelInstance)
            ->with('create', false);
    }

    public function fillModelInstance($modelInstance, $request)
    {
        $modelInstance->{$this->apiName} = json_encode($request->{$this->apiName});
    }

    public function validateField(): array
    {
        return [];
    }


}

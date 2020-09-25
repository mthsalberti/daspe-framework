<?php

namespace Daspeweb\Framework\Field;

class Radio extends Field
{
    use DaspewebModel;
    public $internalName = "radio";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function optionList($options){
        $this->options = $options;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.radio', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.radio', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.radio', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [];
    }

}

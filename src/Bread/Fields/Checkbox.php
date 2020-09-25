<?php

namespace Daspeweb\Framework\Field;

class Checkbox extends Field
{
    use DaspewebModel;
    public $internalName = "checkbox";
    public $defaultOn = false;

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function defaultOn(){
        $this->defaultOn = true;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.checkbox', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.checkbox', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.checkbox', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [
            'boolean'
        ];
    }
}

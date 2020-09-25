<?php

namespace Daspeweb\Framework\Field;

class ColorField extends Field
{
    use DaspewebModel;
    public $internalName = "color";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return "TODO";
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.color', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.color', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.color', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [];
    }

}

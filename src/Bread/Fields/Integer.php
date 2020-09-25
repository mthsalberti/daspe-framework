<?php

namespace Daspeweb\Framework\Field;

class Integer extends Field
{
    use DaspewebModel;
    public $internalName = "integer";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.integer', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.text', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.integer', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.integer', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [
            'nullable',
            'integer',
        ];
    }

}

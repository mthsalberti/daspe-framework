<?php

namespace Daspeweb\Framework\Field;

class Hidden extends Field
{
    use DaspewebModel;
    public $internalName = "hidden";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.hidden', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.hidden', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.hidden', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.hidden', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [
            'nullable',
        ];
    }
}

<?php

namespace Daspeweb\Framework\Field;

class TextArea extends Field
{
    use DaspewebModel;
    public $internalName = "textarea";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.textarea', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.textarea', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.textarea', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.textarea', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [
            'nullable'
        ];
    }


}

<?php

namespace Daspeweb\Framework\Field;

class URL extends Field
{
    use DaspewebModel;
    public $internalName = "url";

    public $prefix = '';

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function prefixToClick($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.url', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.url', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.text', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.text', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [
            'nullable',
            'url'
        ];
    }
}

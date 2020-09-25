<?php

namespace Daspeweb\Framework\Field;

class Percentual extends Field
{
    use DaspewebModel;
    public $internalName = "percentual";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.percentual', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.percentual', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.percentual', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }
    public function renderEditView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.percentual', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return ['nullable', 'numeric'];
    }



}

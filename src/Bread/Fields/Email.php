<?php

namespace Daspeweb\Framework\Field;

class Email extends Field
{
    use DaspewebModel;
    public $internalName = "email";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }


    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse..email', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.email', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.email', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [
            'email'
        ];
    }

}

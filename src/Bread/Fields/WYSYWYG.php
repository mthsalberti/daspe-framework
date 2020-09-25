<?php

namespace Daspeweb\Framework\Field;

class WYSYWYG extends Field
{
    use DaspewebModel;
    public $internalName = "wysywyg";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse..' . self::INTERNAL_TYPE, ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.' . self::INTERNAL_TYPE, ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.wysywyg', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [];
    }

}

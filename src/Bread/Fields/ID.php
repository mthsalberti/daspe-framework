<?php

namespace Daspeweb\Framework\Field;

class ID extends Field
{
    use DaspewebModel;
    public $internalName = "id";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.id', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.id', ['field' => $this, 'modelInstance' => $modelInstance]);
    }
    public function renderAddView($modelInstance)
    {
        return "TODO";
    }

    public function validateField(): array
    {
        return [];
    }


}

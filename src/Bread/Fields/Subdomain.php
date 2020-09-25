<?php

namespace Daspeweb\Framework\Field;

class Subdomain extends Field
{
    use DaspewebModel;

    public $internalName = "subdomain";
    public $isLinkForMain = false;

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function isLinkForMainRecord(){
        $this->isLinkForMain = true;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.subdomain', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.subdomain', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.subdomain', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [
            'nullable'
        ];
    }
}

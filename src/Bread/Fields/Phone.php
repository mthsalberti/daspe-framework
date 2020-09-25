<?php

namespace Daspeweb\Framework\Field;

use App\Rules\BrazilianPhone;

class Phone extends Field
{
    use DaspewebModel;
    public $internalName = "phone";
    public $mask = '00 0000 00009';

    public $makeItNotALink = false;

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function makeItNotALink(){
        $this->makeItNotALink = true;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.phone', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.phone', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.phone', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [
//            new BrazilianPhone()
        ];
    }
}

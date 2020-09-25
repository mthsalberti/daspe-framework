<?php

namespace Daspeweb\Framework\Field;

use App\Rules\BrazilianPostalCode;

class CEP extends Field
{
    use DaspewebModel;
    public $internalName = "cep";
    public $mask = '00000-000';

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.text', ['field'=> $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.text', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.cep', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [
            new BrazilianPostalCode()
        ];
    }

}

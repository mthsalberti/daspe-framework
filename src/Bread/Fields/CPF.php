<?php

namespace Daspeweb\Framework\Field;

use App\Rules\BrazilianDocument;

class CPF extends Field
{
    use DaspewebModel;
    public $internalName = "cpf";
    public $mask = '000.000.000-00';

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.cpf', ['field'=> $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.text', ['field'=> $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.cpf', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function validateField(): array
    {
        return [
            new BrazilianDocument,
            'nullable'
        ];
    }
}

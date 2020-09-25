<?php

namespace Daspeweb\Framework\Field;

use Illuminate\Support\Facades\Hash;

class Password extends Field
{
    use DaspewebModel;
    public $internalName = "password";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return "TODO";
    }

    public function renderReadView($modelInstance)
    {
        return "TODO";
    }

    public function renderAddView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.password', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }
    public function renderEditView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.password', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [
            'confirmed',
            'nullable'
        ];
    }

    public function fillModelInstance($modelInstance, $request)
    {
        if($request->input($this->apiName) != ""){
            $modelInstance->{$this->apiName} = Hash::make($request->input($this->apiName)) ;
        }
    }

}

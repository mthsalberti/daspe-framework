<?php

namespace Daspeweb\Framework\Field;

class Date extends Field
{
    use DaspewebModel;
    public $internalName = "date";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.date', ['field'=> $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.date', ['field'=> $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.date', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function fillModelInstance($modelInstance, $request)
    {
        if (!request()->has($this->apiName) || request()->input($this->apiName) == '') return;
        $date = \DateTime::createFromFormat('j/m/Y', $request->input($this->apiName));
        $date->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
        $modelInstance->{$this->apiName} = $date;
    }

    public function validateField(): array
    {
        return [
            'nullable',
            'regex:/([0-9]{2}([\/])([0-9]{2})([\/])([0-9]{4}))/i'
        ];
    }


}

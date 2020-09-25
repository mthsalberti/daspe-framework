<?php

namespace Daspeweb\Framework\Field;

use Carbon\Carbon;

class Timestamp extends Field
{
    use DaspewebModel;
    public $internalName = "timestamp";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        if($apiName == 'updated_at'){
            $newInstance->breakUp();
        }
        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.timestamp', ['field'=> $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.timestamp', ['field'=> $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.timestamp', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function fillModelInstance($modelInstance, $request)
    {
        if (!request()->has($this->apiName) || request()->input($this->apiName) == '') return;
        $date = Carbon::createFromFormat('d/m/Y H:i', $request->input($this->apiName));
        $date->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
        $modelInstance->{$this->apiName} = $date;
    }

    public function validateField(): array
    {
        return ['nullable'];
    }

}

<?php

namespace Daspeweb\Framework\Field;

class SelectDropdown extends Field
{
    use DaspewebModel;
    public $internalName = "selectdropdown";

    public $options = [];
    public $colorByOption = [];
    public $default;
    public $showAsBadge = false;

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function optionListColor($colorByOption){
        $ncolorByOption = [];
        foreach($colorByOption as $key => $value){
            $ncolorByOption[strtolower($key)] = $value;
        }
        $this->colorByOption = $ncolorByOption;
        return $this;
    }

    public function showAsBadge($show = true){
        $this->showAsBadge = $show;
        return $this;
    }

    public function optionList($options){
        $this->options = $options;
        return $this;
    }

    public function defaultOption($default){
        $this->default = $default;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.select', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.select-dropdown', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.select-dropdown', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view ('daspeweb::app_layout.bread-add-edit.select-dropdown', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [];
    }

}

<?php

namespace Daspeweb\Framework;

class BreadExtensionPage
{
    public $path;
    public $label;
    public $icon = '';
    public $tabName = '';
    public $callbackName = '';
    public $dataAttrArr = [];

    public static function path($path)
    {
        $newInstance = new self();
        $newInstance->path = $path;
        $newInstance->dataAttrArr[] = ['name' => 'model-id', 'value' => '{id}'];
        return $newInstance;
    }

    public function tabName($tabName){
        $this->tabName = $tabName;
        return $this;
    }

    public function callbackName($callbackName){
        $this->callbackName = $callbackName;
        return $this;
    }

    public function addDataAttr($name, $value){
        $this->dataAttrArr[] = ['name' => $name, 'value' => $value];
        return $this;
    }

    public function renderDataAttr($modelInstance){
        $pattern = '/(.*)({)([a-z_]+)(})(.*)/';
        foreach ($this->dataAttrArr as $data){
            preg_match($pattern, $data['value'], $matches);
            $realValue = $matches[1]. $modelInstance->{$matches[3]} . (array_key_exists(5, $matches) ? $matches[5] : '');
            $data['value'] = $realValue;
        }
    }

    public function label($label){
        $this->label = $label;
        return $this;
    }

    public function icon($icon){
        $this->icon = $icon;
        return $this;
    }

}

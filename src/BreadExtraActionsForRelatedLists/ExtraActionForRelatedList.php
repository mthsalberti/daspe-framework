<?php

namespace Daspeweb\Framework;

class ExtraActionForRelatedList
{
    public $name;
    public $link = '';
    public $icon = '';
    public $target = '_self';
    public $whereList = [];
    public $isModal = false;
    public $queryAttrs = [];

    public static function make($name){
        $newInstance = new self();
        $newInstance->name = $name;
        return $newInstance;
    }

    public function attr($name, $value){
        $this->queryAttrs[$name] = $value;
        return $this;
    }

    public function link($link){
        $this->link = $link;
        return $this;
    }

    public function icon($icon){
        $this->icon = $icon;
        return $this;
    }

    public function onClick($target){
        $this->target = $target;
        if($target == 'modal'){
            $this->isModal = true;
            $this->queryAttrs['use_modal_form'] = '1';
        }
        return $this;
    }

    public function makeLink($modelInstance){
        foreach ($this->queryAttrs as $inputName => $inputValue){
            if(preg_match('/([{])(.*)([}])/', $inputValue)){
                preg_match('/([{])(.*)([}])/', $inputValue, $matches);
                $this->queryAttrs[$inputName] = $modelInstance->{$matches[2]};
            }
        }
        $query = $this->link .'?'. http_build_query($this->queryAttrs);
        return $query;
    }

    public function makeCssClass(){
        return strtolower(preg_replace("/[^A-Za-z0-9?!]/","_",$this->name));
    }
}

<?php

namespace Daspeweb\Framework;

class ExtraAction
{
    public $name;
    public $onModelMainPage;
    public $onBrowseView;
    public $onReadView;
    public $onEditView;
    public $onAddView;
    public $onDeleteView;
    public $link = '';
    public $icon = '';
    public $extraClass = '';
    public $target = '_self';
    public $whereList = [];

    public static function make($name){
        $newInstance = new self();
        $newInstance->name = $name;
        return $newInstance;
    }

    public function extraClass($extraClass){
        $this->extraClass = $extraClass;
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
        return $this;
    }

    public function onBrowseView(){
        $this->onBrowseView = true;
        return $this;
    }

    public function onReadView(){
        $this->onReadView = true;
        return $this;
    }

    public function onEditView(){
        $this->onEditView = true;
        return $this;
    }

    public function onAddView(){
        $this->onAddView = true;
        return $this;
    }

    public function onModelMainPage(){
        $this->onModelMainPage = true;
        return $this;
    }

    public function where($field, $criteria, $value){
        $arr = [
            'field' => $field,
            'criteria' => $criteria,
            'value' => $value,
        ];
        array_push($this->whereList, $arr);
        return $this;
    }
    public function whereEq($field, $value){
        return $this->where($field, '=', $value);
    }

    public function checkCriteria($modelInstance){
        foreach ($this->whereList as $where){
            if ($where['criteria'] == '='){
                if ($modelInstance->{$where['field']} != $where['value']){
                    return false;
                }
            }else if ($where['criteria'] == '<>' || $where['criteria'] == '!='){
                if ($modelInstance->{$where['field']} == $where['value']){
                    return false;
                }
            }else if ($where['criteria'] == '<'){
                if ($modelInstance->{$where['field']} >= $where['value']){
                    return false;
                }
            }else if ($where['criteria'] == '>'){
                if ($modelInstance->{$where['field']} <= $where['value']){
                    return false;
                }
            }else if ($where['criteria'] == '>='){
                if ($modelInstance->{$where['field']} < $where['value']){
                    return false;
                }
            }else if ($where['criteria'] == '<='){
                if ($modelInstance->{$where['field']} > $where['value']){
                    return false;
                }
            }
        }
        return true;
    }

    public function makeLink($modelInstance){
        $pattern = '/(.*)({)([a-z_]+)(})(.*)/';
        preg_match($pattern, $this->link, $matches);
        $realLink = $matches[1]. $modelInstance->{$matches[3]} . (array_key_exists(5, $matches) ? $matches[5] : '');
        return $realLink;
    }

    public function makeCssClass(){
        $s = str_replace($this->name, " ", "_");
        return preg_replace("/[^A-Za-z0-9?! ]/","",$s);
    }
}

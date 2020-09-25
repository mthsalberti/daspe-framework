<?php

namespace Daspeweb\Framework\Field;

abstract class Field
{

    protected $internalName = '';
    public $label;
    public $apiName;
    public $searchable;
    public $onBrowseView;
    public $onReadView;
    public $onEditView;
    public $onAddView;

    public $readonlyHTML = false;

    public $isLinkForMain = false;

    public $strLimit = 1000;

    //for relationship fields
    public $method;
    public $relatedLink;
    public $displayRelated;

    //format settings
    public $format = null;

    //radio options
    public $options = [];
    public $default = '';

    //display settings
    public $breakUp = false;
    public $breakDown = false;
    public $width = 'col-12 col-md-3';

    public function isLinkForMainRecord(){
        $this->isLinkForMain = true;
        return $this;
    }

    public function stringLimit($strLimit){
        $this->strLimit = $strLimit;
        return $this;
    }

    public function readonlyHTML(){
        $this->readonlyHTML = true;
        return $this;
    }

    public function breakUp(){
        $this->breakUp = true;
        return $this;
    }

    public function breakDown(){
        $this->breakDown = true;
        return $this;
    }

    public function width($width){
        $this->width = $width;
        return $this;
    }

    public function format($format){
        $this->format = $format;
        return $this;
    }

    public function label($label){
        $this->label = $label;
        return $this;
    }

    public function default($default){
        $this->default = $default;
        return $this;
    }

    public function searchable(){
        $this->searchable = true;
        return $this;
    }

    public function fastSetting($browse = true, $read = true, $edit = true, $add = true, $searchable = true){
        $this->onBrowseView = $browse;
        $this->onReadView = $read;
        $this->onEditView = $edit;
        $this->onAddView = $add;
        $this->searchable = $searchable;
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

    public function fillModelInstance($modelInstance, $request){
        $modelInstance->{$this->apiName} = $request->input($this->apiName);
    }

    public abstract function renderBrowseView($modelInstance);
    public abstract function renderReadView($modelInstance);
    public function renderEditView($modelInstance){
        $viewName = 'daspeweb::app_layout.bread-add-edit.'.$this->internalName;
        return view($viewName, ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }
    public abstract function renderAddView($modelInstance);
    public abstract function validateField() : array;

}

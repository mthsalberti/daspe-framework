<?php

namespace Daspeweb\Framework\Field;

class HasManyField extends Field
{
    use DaspewebModel;
    public $internalName = "hasMany";

    public $togglable = false;
    public $fieldsToShow = [];

    public static function callMethod($method)
    {
        $newInstance = new self();
        $newInstance->method = $method;
        $newInstance->apiName = $method;
        return $newInstance;
    }

    public function displayOnRelated($displayRelated = 'name'){
        $this->displayRelated = $displayRelated;
        array_push($this->fieldsToShow, $displayRelated);
        return $this;
    }

    public function togglable(){
        $this->togglable = true;
        $this->internalName = 'relationships.belongsToMany.belongs-to-many-toggle';
        return $this;
    }

    public function makeALinkForRelated($relatedLink = null){
        if ($relatedLink == null){
            $relatedLink = '/admin/'.$this->method.'/{id}';
        }
        $this->relatedLink = $relatedLink;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse.has-many', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.has-many', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        if ($this->togglable){
            return view('daspeweb::app_layout.bread-add-edit.relationships.belongsToMany.belongs-to-many-toggle', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
        }
        return view('daspeweb::app_layout.bread-add-edit.relationships.belongsToMany.belongs-to-many', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function fillModelInstance($modelInstance, $request)
    {
        if ($request->has($this->apiName)){
            $this->checkIfExists($modelInstance);
            $idToSync = $request->input($this->apiName);
            $modelInstance->{$this->method}()->sync($idToSync);
        }
    }

    private function checkIfExists($modelInstance){
        if ($modelInstance->id == null){
            $modelInstance->save();
        }
    }

    public function validateField(): array
    {
        return [];
    }


}

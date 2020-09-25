<?php

namespace Daspeweb\Framework\Field;

class BelongsToMorphField extends Field
{
    use DaspewebModel;
    public $internalName = "belongsToMorph";

    public $belongsToList = [];

    public static function make($arr){
        $instance = new self();
        $instance->belongsToList = $arr;
        return $instance;
    }

    public function label($label){
        $this->label = $label;
        $this->apiName = $label;
        return $this;
    }

    public function renderBrowseView($modelInstance)
    {
        foreach ($this->belongsToList as $relationShip){
            if ($modelInstance->{$relationShip->method} != null){
                return $relationShip->renderBrowseView($modelInstance);
            }
        }
    }

    public function renderReadView($modelInstance)
    {
        $relationshipToUse = collect($this->belongsToList)->first(function($relation, $index) use($modelInstance){
            return $modelInstance->{$relation->method} != null;
        });
        if ($relationshipToUse != null){
            return $relationshipToUse->renderReadView($modelInstance);
        }
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.relationships.belongsToMorph.belongs-to-morph', ['field' => $this, 'create' => true, 'modelInstance' => $modelInstance, 'belongsToArr' => $this->belongsToList]);
    }

    public function fillModelInstance($modelInstance, $request)
    {
        $method = request()->input($this->makeInputName());
        $relationshipToUse = collect($this->belongsToList)->first(function($relation, $index) use($method){
            return $relation->method == $method;
        });
        $relationshipToUse->fillModelInstance($modelInstance, $request);
    }

    public function makeInputName(){
        return strtolower(preg_replace("/[^A-Za-z0-9?!]/","",$this->label));
    }

    public function validateField(): array
    {
        return [
        ];
    }


}

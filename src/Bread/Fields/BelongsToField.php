<?php

namespace Daspeweb\Framework\Field;

use Daspeweb\Framework\DaspewebHelper;

class BelongsToField extends Field
{
    use DaspewebModel;
    public $internalName = "belongsTo";

    public $target = '_self';
    public $fieldsToSearchFor = [];
    public $fieldsToRetrieveOnSearch = [];
    public $fieldsToShowOnInput = [];
    public $filterBeforeSearch = [];
    public $fixedFilter = [];
    public $makeItNotAlink = false;
    public $isCount = false;
    public $displayRelated;
    public $lookupSlug = '';
    private $allowNewEntry = false;
    public $toggle = false;
    public $toggleWhenModal = false;
    public $isFirstDefault = false;
    public $orderBy = [];

    public static function make($model, $methodName = null){
        $modelInfo = DaspewebHelper::infoByNamespace($model);//retorna info da DwModel
        $newInstance = new self();
        $newInstance->method = $methodName ?? lcfirst($modelInfo->name);
        $newInstance->apiName = $newInstance->method;
        $newInstance->lookupSlug = $modelInfo->slug;
        $newInstance->relatedLink = '/admin/'.$newInstance->lookupSlug.'/{id}';
        $newInstance->displayOnRelated('name');
        return $newInstance;
    }
    public static function callMethod($method)
    {
        $newInstance = new self();
        $newInstance->method = $method;
        $newInstance->apiName = $method;

        $newInstance->displayOnRelated('name');
        return $newInstance;
    }

    public function fixedFilter($field, $criteria, $value){
        array_push($this->fixedFilter, [
            'field-to-search' => $field,
            'criteria' => $criteria,
            'value' => $value
        ]);
        return $this;
    }


    public function orderBy($arr){
        array_push($this->orderBy, $arr);
        return $this;
    }

    public function makeItNotALink(){
        $this->makeItNotAlink = true;
        return $this;
    }

    public function isCount(){
        $this->isCount = true;
        return $this;
    }

    public function isFirstDefault(){
        $this->isFirstDefault = true;
        return $this;
    }

    public function allowNewEntry(){
        $this->allowNewEntry = true;
        return $this;
    }

    public function toggle(){
        $this->toggle = true;
        return $this;
    }

    public function toggleWhenModal(){
        $this->toggleWhenModal = true;
        return $this;
    }

    public function onClick($target){
        $this->target = $target;
        return $this;
    }

    public function fieldsToRetrieveOnSearch($arr){
        $this->fieldsToRetrieveOnSearch = $arr;
        return $this;
    }

    public function fieldsToSearchFor($arr){
        $this->fieldsToSearchFor = $arr;
        return $this;
    }

    public function beforeSearchFilter($fieldToSend, $criteria, $fieldToGet){
        array_push($this->filterBeforeSearch, [
            'field-to-search' => $fieldToSend,
            'criteria' => $criteria,
            'field-to-get' => $fieldToGet,
        ]);
        return $this;
    }

    public function fieldsToShowOnInput($arr){
        $this->fieldsToShowOnInput = $arr;
        foreach ($arr as $item){
            if (!array_has($this->fieldsToRetrieveOnSearch, $item)){
                array_push($this->fieldsToRetrieveOnSearch,$item );
            }
        }
        return $this;
    }

    public function lookupSlug($lookupSlug){
        $this->lookupSlug = $lookupSlug;
        $this->relatedLink = '/admin/'.$lookupSlug.'/{id}';
        return $this;
    }

    public function displayOnRelated($displayRelated = 'name'){
        $this->displayRelated = $displayRelated;
        if(!count($this->fieldsToRetrieveOnSearch)) $this->fieldsToRetrieveOnSearch = [$displayRelated];
        if(!count($this->fieldsToSearchFor)) $this->fieldsToSearchFor = [$displayRelated];
        if(!count($this->fieldsToShowOnInput)) $this->fieldsToShowOnInput = [$displayRelated];
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
        return view('daspeweb::app_layout.bread-browse.belongs-to', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.belongs-to', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        $isModal = request()->has('use_modal_form');
        if($this->toggle || ($this->toggleWhenModal && $isModal)){
            return view('daspeweb::app_layout.bread-add-edit.relationships.belongsTo.belongs-to-toggle', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
        }
        return view('daspeweb::app_layout.bread-add-edit.relationships.belongsTo.belongs-to', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        $isModal = request()->has('use_modal_form');
        if($this->toggle || ($this->toggleWhenModal && $isModal)){
            return view('daspeweb::app_layout.bread-add-edit.relationships.belongsTo.belongs-to-toggle', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
        }
        return view('daspeweb::app_layout.bread-add-edit.relationships.belongsTo.belongs-to', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function fillModelInstance($modelInstance, $request)
    {
        $related = $modelInstance->{$this->method}()->getModel();

        if($request->input($this->apiName) == null && $this->allowNewEntry){
            $related->{$this->displayRelated} = $request->input($this->apiName . '_autocomplete');
            if($related != null) $related->save();
        }else if($request->input($this->apiName) != null){
            $related = $related::find($request->input($this->apiName));
        }
        if ($related->id != null) $modelInstance->{$this->method}()->associate($related);
    }

    public function getOptionWhenToggle($modelInstance){
        if (count($this->orderBy) > 0){
            $query = $modelInstance->{$this->method}()->getModel()::where('id', '<>', '');
        }else{
            $query = $modelInstance->{$this->method}()->getModel()::orderBy($this->fieldsToShowOnInput[0]);
        }
        if(count($this->fixedFilter)){
            foreach ($this->fixedFilter as $filter){
                $query->where($filter['field-to-search'], $filter['value']);
            }
        }
        foreach($this->filterBeforeSearch as $filter){
            if(request()->has($filter['field-to-get'])){
                $query->where($filter['field-to-search'], '=', request()->input($filter['field-to-get']));
            }else{
                $query->where($filter['field-to-search'], '=', $modelInstance->{$filter['field-to-get']});
            }

        }
        if (count($this->orderBy) > 0){
            foreach ($this->orderBy as $key => $field){
                $query->orderBy($field['field'], $field['order']);
            }
        }
        return $query->get();
    }

    public function validateField(): array
    {
        return [
        ];
    }


}

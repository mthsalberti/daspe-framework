<?php

namespace Daspeweb\Framework;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BreadRelatedList
{
//    public $actionList = [];
    public $model;
    public $fields = ['*'];
    public $foreignKey;
    public $tabName = '';
    public $label = null;
    public $relatedButtons = [];
    public $useCard = false;

    public static function call($modelPath, $foreignKey = null)
    {
        $newInstance = new self();
        $newInstance->model = $modelPath;
        $newInstance->foreignKey = $foreignKey;
        //$newInstance->tabName = $slug . '-tab';
        return $newInstance;
    }

    public function constructDefaultCreationButton($parentModel){
        $modelAux = DaspewebHelper::infoByNamespace($this->model);
        $isAllowed = CheckPermission::getInstance()->isAllowedBySlug('A', $modelAux->slug, false);
        if(!$isAllowed) return;
        $label = 'gender' == 'Feminino' ? 'nova ' : 'novo ' . $modelAux->singular_name ;
        $link = '/admin/'.$modelAux->slug.'/create';
        $attrName = lcfirst($parentModel->name);
        foreach ($this->relatedButtons as $button){
            if($button->link == $link) return ;
        }
        $extraActionRL = ExtraActionForRelatedList::make($label)
            ->link($link)
            ->attr($attrName, '{id}')
            ->onClick('modal');
        $this->relatedButtons[] = $extraActionRL;
    }

    public function getForeignKey($parentModel){
        if($this->foreignKey == null){
            $this->foreignKey = snake_case($parentModel->name).'_id';
        }
        return $this->foreignKey;
    }

    public function relatedButtons(array $relatedButtons){
        $this->relatedButtons = $relatedButtons;
        return $this;
    }

    public function tabName($tabName){
        $this->tabName = $tabName;
        return $this;
    }

    public function useCard(){
        $this->useCard = true;
        return $this;
    }

    public function fields($fields){
        $this->fields = $fields;
        return $this;
    }

    public function icon($icon){
        $this->icon = $icon;
        return $this;
    }

    public function label($label){
        $this->label = $label;
        return $this;
    }

//    public function appendModalAction($label, $url)
//    {
//        $actionAux = new \stdClass();
//        $actionAux->type = 'open_modal';
//        $actionAux->label = $label;
//        $actionAux->modal_url = $url;
//        array_push($actionList, $actionAux);
//        return $this;
//    }
}

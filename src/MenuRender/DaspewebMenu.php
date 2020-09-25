<?php

namespace Daspeweb\Framework;

class DaspewebMenu
{
    public static function renderCollapseMenuItem($label, $icon, $children){
        return  view('daspeweb::app_layout.partials.sidebar-item-template-collapse')
            ->with('label', $label)
            ->with('icon', $icon)
            ->with('children', $children)
            ->render();
    }

    public static function renderMenuItem($label, $path, $icon){
        $cls = new \stdClass();
        $cls->plural_name = $label;
        $cls->slug = $path;
        $cls->icon = $icon;
        return  view('daspeweb::app_layout.partials.sidebar-item-template')
            ->with('menu', $cls)
            ->render();
    }

    public static function renderMenuItemModel($slug){
        $modelInfo = DaspewebHelper::info($slug);
        $modelInfo->slug = '/admin/' . $modelInfo->slug;
        return  view('daspeweb::app_layout.partials.sidebar-item-template')
            ->with('menu', $modelInfo)
            ->render();
    }
}

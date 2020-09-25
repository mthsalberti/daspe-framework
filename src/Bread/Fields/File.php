<?php

namespace Daspeweb\Framework\Field;

use Illuminate\Support\Facades\Storage;

class File extends Field
{
    use DaspewebModel;
    public $internalName = "file";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return "TODO";
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.file', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.file', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }
    public function fillModelInstance($modelInstance, $request)
    {
        if ($request->has($this->apiName)){
            $arrFileInfo = [];
            $arrFileInfo2 = self::saveFile(\request()->file($this->apiName), $arrFileInfo);
            $modelInstance->{$this->apiName} = json_encode($arrFileInfo2);
        }
    }
    public static function saveFile($fileInput)
    {
        $filePath =  Storage::disk('gcs')->put(self::pathToSave(), $fileInput);
        return $filePath;
    }
    private static function pathToSave(){
//        $website = website();
        return '/' . 'fortefarma/settings';
    }
    public function validateField(): array
    {
        return [];
    }


}

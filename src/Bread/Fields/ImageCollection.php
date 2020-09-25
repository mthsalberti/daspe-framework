<?php

namespace Daspeweb\Framework\Field;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Intervention\Image\Facades\Image as InterImage;

class ImageCollection extends Field
{
    use DaspewebModel;
    public $internalName = "imagecollection";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse..image-collection', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.image-collection', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.image-collection', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.image-collection', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }


    public function fillModelInstance($modelInstance, $request)
    {
        $arrImgInfo = [];
        $existingJsonColl = json_decode($modelInstance->{$this->apiName}, true);
//        dd($request->all());
        if ($request->has($this->apiName.'_aux')){
            foreach ($request->input($this->apiName.'_aux') as $index => $uploadedFile){
                if($request->input($this->apiName.'_aux')[$index] == "1"){
                    $this->deleteOneImage($existingJsonColl[$index]);
                }else{
                    array_push($arrImgInfo, $existingJsonColl[$index]);
                }
            }
        }

        $allInput = [];
        if ($request->has($this->apiName)){
            $allInput = $request->file($this->apiName);
        }
        if ($request->has($this->apiName.'_replace')){
            $allInput += $request->file($this->apiName.'_replace');
        }

        foreach($allInput as $uploadedFile){
            if($request->input($uploadedFile.'_aux') == "1"){
                $this->deleteImages($modelInstance);
            }
            $arrImgInfo = Image::saveImage($uploadedFile, $arrImgInfo);
        }

        $modelInstance->{$this->apiName} = json_encode($arrImgInfo);
    }


    private function deleteOneImage($arr){
        if (\Storage::disk('gcs')->exists($arr['path'])) {
            Storage::disk('gcs')->delete($arr['path']);
        }
        if (\Storage::disk('gcs')->exists($arr['path-low'])) {
            Storage::disk('gcs')->delete($arr['path-low']);
        }
    }

    public function validateField(): array
    {
        return [
            'bail',
            'nullable',
            'image',
            // 'max:4096'
        ];
    }

    public static function getWidth($json){
        $imgDetails = json_decode($json);
        if ($imgDetails != null && property_exists($imgDetails, 'width')){
            return $imgDetails->width;
        }
        return '400';
    }
    public static function getHeight($json){
        $imgDetails = json_decode($json);
        if ($imgDetails != null && property_exists($imgDetails, 'height')){
            return $imgDetails->height;
        }
        return '400';
    }


}

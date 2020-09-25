<?php

namespace Daspeweb\Framework\Field;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use \Intervention\Image\Facades\Image as InterImage;

class Image extends Field
{
    use DaspewebModel;
    public $internalName = "image";

    public static function make($apiName)
    {
        $newInstance = new self();
        $newInstance->apiName = $apiName;

        return $newInstance;
    }

    public function renderBrowseView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-browse..image', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderReadView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-show.image', ['field' => $this, 'modelInstance' => $modelInstance]);
    }

    public function renderAddView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.image2', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => true]);
    }

    public function renderEditView($modelInstance)
    {
        return view('daspeweb::app_layout.bread-add-edit.image2', ['field' => $this, 'modelInstance' => $modelInstance, 'create' => false]);
    }

    public function validateField(): array
    {
        return [
            'nullable',
            'image',
            'max:9216'
        ];
    }

    public function fillModelInstance($modelInstance, $request)
    {
        $arrImgInfo = [];
        if($request->input($this->apiName.'_aux') == "1"){
            $this->deleteImages($modelInstance);
            $modelInstance->{$this->apiName} = json_encode([]);
        }
        if ($request->has($this->apiName)){
            $arrImgInfo = [];
            $arrImgInfo2 = self::saveImage(\request()->file($this->apiName), $arrImgInfo);
            $modelInstance->{$this->apiName} = json_encode($arrImgInfo2);
        }
    }

    public static function saveImage($image, $arrImgInfo){
        $uuid = uniqid('');
        $highQualityImageOriginal = InterImage::make(new File($image));
        $highQualityImageHigher = InterImage::make(new File($image));

        $highQualityImageOriginal = $highQualityImageOriginal->widen(700, function ($constraint) {
            $constraint->upsize();
        });

        $highQualityImageHigher = $highQualityImageHigher->widen(1800, function ($constraint) {
            $constraint->upsize();
        });

        $highQualityImagePath = self::pathToSave() .'/' . $uuid. '.' . $image->getClientOriginalExtension();

        $lowImage = InterImage::make(new File($image))->resize(240, null, function ($constraint) {$constraint->aspectRatio(); $constraint->upsize();});
        $lowImagePath = self::pathToSave() .'/' . $uuid.'-low.'.$image->getClientOriginalExtension();
        $higherImagePath = self::pathToSave() .'/' . $uuid.'-higher.'.$image->getClientOriginalExtension();

        Storage::disk('gcs')->put($lowImagePath, $lowImage->encode());
        Storage::disk('gcs')->put($highQualityImagePath, $highQualityImageOriginal->encode());
        Storage::disk('gcs')->put($higherImagePath, $highQualityImageHigher->encode());

        array_push($arrImgInfo, [
            'path'      => $highQualityImagePath,
            'path-low'  => $lowImagePath,
            'path-higher'  => $higherImagePath,
            'width'     => $highQualityImageOriginal->width(),
            'height'     => $highQualityImageOriginal->height(),
        ]);
        return $arrImgInfo;
    }

    private static function pathToSave(){
//        $website = website();
        return '/' . config('filesystems.disks.gcs.project_name').'/'.\Daspeweb\Framework\DaspewebHelper::slug();
    }

    private function deleteImages($modelInstance){
        $imgCollJson = json_decode($modelInstance->{$this->apiName}, true);
        if (count($imgCollJson) > 0){
            $img = $imgCollJson[0];
            if (\Storage::disk('gcs')->exists($img['path'])) {
                Storage::disk('gcs')->delete($img['path']);
            }
            if (\Storage::disk('gcs')->exists($img['path-low'])) {
                Storage::disk('gcs')->delete($img['path-low']);
            }
        }
    }

    public static function getLowPath($json){
        $imgDetails = json_decode($json, true);
        if (isset($imgDetails[0]['path-low'])){
            return '/storage/' . $imgDetails[0]['path-low'];
        }
        return '';
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

<?php

namespace App;

use Daspeweb\Framework\Field\BelongsToField;
use Daspeweb\Framework\Field\DaspewebModel;
use Daspeweb\Framework\Field\ID;
use Daspeweb\Framework\Field\Text;
use Illuminate\Database\Eloquent\Model;

class DwPermissionDetail extends Model
{
    use DaspewebModel;

    protected $fillable = ['dw_model_id', 'permission_name'];

    public static $hasOwnerField = false;

    public function model(){
        return $this->belongsTo(DwModel::class, 'dw_model_id');
    }

    public function permissionDetailRole(){
        return $this->hasMany(DwPermissionDetailRole::class);
    }

    public static function fields(){
        return collect([
            ID::make('id')->label('Código'),
            Text::make('permission_name')->label('Name')->fastSetting(),
            BelongsToField::callMethod('model')->label('Model')
                ->lookupSlug('dw-models')->fastSetting(),
        ]);
    }
}

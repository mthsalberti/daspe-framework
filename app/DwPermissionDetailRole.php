<?php

namespace App;

use Daspeweb\Framework\Field\BelongsToField;
use Daspeweb\Framework\Field\Checkbox;
use Daspeweb\Framework\Field\DaspewebModel;
use Daspeweb\Framework\Field\ID;
use Illuminate\Database\Eloquent\Model;

class DwPermissionDetailRole extends Model
{
    use DaspewebModel;
    protected $table = 'dw_permission_detail_role';
    protected $fillable = ['dw_permission_detail_id', 'role_id', 'is_allowed'];
    public static $hasOwnerField = false;

    public function dwPermissionDetail(){
        return $this->belongsTo(DwPermissionDetail::class, 'dw_permission_detail_id')
            ->orderBy('permission_name');
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public static function fields(){
        return collect([
            ID::make('id')->label('Código'),
            BelongsToField::callMethod('dwPermissionDetail')
                ->label('Conjunto de permissão')
                ->displayOnRelated('id')
                ->lookupSlug('dw-permission-details')->fastSetting(),
            BelongsToField::callMethod('role')
                ->label('Perfil')
                ->lookupSlug('roles')->fastSetting(),
            Checkbox::make('is_allowed')->label('Permitido?')->fastSetting(),
        ]);
    }
}

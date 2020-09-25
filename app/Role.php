<?php

namespace App;

use Daspeweb\Framework\Field\DaspewebModel;
use Daspeweb\Framework\Field\ID;
use Daspeweb\Framework\Field\Text;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use DaspewebModel;

    protected $fillable = ['name', 'name_api'];
    public static $singularName = 'perfil';
    public static $pluralName = 'perfis';
    public static $icon = 'fas fa-user-lock';
    public static $hasOwnerField = false;

    public static function fields(){
        return collect([
            ID::make('id')->label('Código'),
            Text::make('name')->label('Name')->fastSetting(),
            Text::make('name_api')->label('API Name')->fastSetting(),
        ]);
    }
}

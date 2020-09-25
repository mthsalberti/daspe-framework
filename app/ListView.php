<?php

namespace App;

use Daspeweb\Framework\BreadRelatedList;
use Daspeweb\Framework\Field\BelongsToField;
use Daspeweb\Framework\Field\Checkbox;
use Daspeweb\Framework\Field\DaspewebModel;
use Daspeweb\Framework\Field\ID;
use Daspeweb\Framework\Field\Text;
use Daspeweb\Framework\Field\Timestamp;
use Illuminate\Database\Eloquent\Model;

class ListView extends Model
{
    use DaspewebModel;
    protected $fillable = ['name', 'is_only_for_me', 'user_id', 'dw_model_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function criterias(){
        return $this->hasMany(ListViewCriteria::class);
    }

    public static function fields(){
        return collect([
            ID::make('id')->label('Código'),
            Text::make('name')->label('Nome')->fastSetting(),
            Checkbox::make('is_only_for_me')->label('Privado?')->fastSetting(),
            BelongsToField::make(User::class)->fastSetting(),
            Timestamp::make('created_at')->label('Criado em')->format('d/m/Y')->breakUp()->fastSetting(0,1,0,0,0),
            Timestamp::make('updated_at')->label('Alterado em')->format('d/m/Y')->fastSetting(0,1,0,0,0),
            Timestamp::make('deleted_at')->label('Excluído em')->format('d/m/Y'),
        ]);
    }

    public static function relatedLists(){
        return collect([
            BreadRelatedList::call(ListViewCriteria::class)
        ]);
    }
}

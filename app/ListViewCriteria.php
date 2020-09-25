<?php

namespace App;

use Daspeweb\Framework\Field\BelongsToField;
use Daspeweb\Framework\Field\Checkbox;
use Daspeweb\Framework\Field\DaspewebModel;
use Daspeweb\Framework\Field\ID;
use Daspeweb\Framework\Field\Text;
use Daspeweb\Framework\Field\Timestamp;
use Illuminate\Database\Eloquent\Model;

class ListViewCriteria extends Model
{
    use DaspewebModel;

    protected $fillable = ['list_view_id', 'field_api', 'field_label', 'criteria_api',
        'criteria_label', 'value', 'value_api', 'field_type'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function listView(){
        return $this->belongsTo(ListView::class);
    }
    public static function fields(){
        return collect([
            ID::make('id')->label('Código'),
            BelongsToField::make(ListView::class)->label('Modo de visualização')->fastSetting(),
            Text::make('field_type')->label('Tipo')->fastSetting(),
            Text::make('field_api')->label('Field API')->fastSetting(),
            Text::make('field_label')->label('Field label')->fastSetting(),
            Text::make('criteria_api')->label('Criteria API')->fastSetting(),
            Text::make('criteria_label')->label('Criteria Label')->fastSetting(),
            Text::make('value')->label('Value')->fastSetting(),
            Text::make('value_api')->label('Value API')->fastSetting(),
            Timestamp::make('created_at')->label('Criado em')->format('d/m/Y')->breakUp()->fastSetting(0,1,0,0,0),
            Timestamp::make('updated_at')->label('Alterado em')->format('d/m/Y')->fastSetting(0,1,0,0,0),
            Timestamp::make('deleted_at')->label('Excluído em')->format('d/m/Y'),
        ]);
    }
}

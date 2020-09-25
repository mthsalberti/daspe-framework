<?php

namespace App;

use Daspeweb\Framework\ExtraAction;
use Daspeweb\Framework\Field\Checkbox;
use Daspeweb\Framework\Field\DaspewebModel;
use Daspeweb\Framework\Field\ID;
use Daspeweb\Framework\Field\SelectDropdown;
use Daspeweb\Framework\Field\Text;
use Illuminate\Database\Eloquent\Model;

class DwModel extends Model
{
    use DaspewebModel;
    protected $fillable =
        ['name', 'namespace', 'model_name', 'snake', 'slug', 'singular_name',
            'icon', 'has_owner_field', 'ownership_fields',
            'plural_name', 'add_new_label', 'edit_label', 'delete_label',
            'is_displayed_on_app_center', 'app_center_group', 'ownership_fields', 'order'];
    public function dwPermissionDetail(){
        return $this->hasMany(DwPermissionDetail::class);
    }

    public static function fields(){
        return collect([
            ID::make('id')->label('Código'),
            Text::make('name')->label('Name')->fastSetting(),
            Text::make('namespace')->label('Namespace')->fastSetting(0),
            Text::make('slug')->label('Slug')->fastSetting(),
            Text::make('singular_name')->label('Nome singular')->fastSetting(),
            Text::make('plural_name')->label('Nome plural')->fastSetting(),
            SelectDropdown::make('gender')->label('Gênero')
                ->optionList(['Feminino' => 'Feminino', 'Masculino' => 'Masculino'])->fastSetting(),
            Text::make('icon')->label('Ícone')->fastSetting(),
            Checkbox::make('hide_view_mode')->label('Bloq view list')->fastSetting(),
            Checkbox::make('has_owner_field')->label('Tem proprietário')->fastSetting(),
            Text::make('ownership_fields')->label('Campos p/ propriet.')->fastSetting(0),
            Checkbox::make('use_card_for_browse')->label('Usar cards')->fastSetting(0),
            Text::make('add_new_label')->label('Add new label')->fastSetting(0),
            Text::make('edit_label')->label('Edit label')->fastSetting(0),
            Text::make('delete_label')->label('Delete label')->fastSetting(0),
            Checkbox::make('is_displayed_on_app_center')->label('Mostrar no app center')->fastSetting(0),
            Text::make('app_center_group')->label('Order by padrão')->fastSetting(0),
            Text::make('default_order_by')->label('Order by padrão')->fastSetting(0),
            Text::make('default_order_by_direction')->label('Direção order by padrão')->fastSetting(0),
        ]);
    }

    public static function extraActions(){
        return [
            ExtraAction::make('acessar')->icon('<i class="fas fa-external-link-square-alt"></i>')
                ->link('/admin/{slug}')->onBrowseView()->onReadView()
        ];
    }


}

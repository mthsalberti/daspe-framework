<?php

namespace Daspeweb\Framework\Console\Commands;

use App\DwModel;
use App\Role;
use App\User;
use Carbon\Carbon;
use Daspeweb\Framework\DaspewebHelper;
use Daspeweb\Framework\Model\ModelNew;
use function GuzzleHttp\Promise\all;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetModelsAndPermissions extends Command
{
    protected $signature = 'daspeweb:permissions';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $path = app_path();
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . '/' . $result;
            $namespace = 'App\\'.preg_replace('/(.*)app\/(.*)(.php)/', '${2}', $filename);
            $modelName = preg_replace('/(.*)app\/(.*)(.php)/', '${2}', $filename);

            if (!is_dir($filename) && $modelName <> 'ModelNew') {
                $out[] = [
                    'namespace' => $namespace,
                    'model_name' => $modelName,
                    'snake' => snake_case($modelName),
                    'slug' => str_plural(snake_case($modelName)),
                    'singular_name' => $modelName,
                    'plural_name' => $modelName,
                ];
            }
        }
        $models = [];
        foreach($out as $key => $value){
            $models[] = \App\DwModel::updateOrCreate(
                ['name' => $value['model_name']],
                [
                    'name' => $value['model_name'],
                    'namespace' => $value['namespace'],
                    'slug' => str_plural(snake_case($value['model_name'])),
                    'singular_name' => $this->getInfoAboutModel('singular_name', $value['model_name']),
                    'plural_name' => $this->getInfoAboutModel('plural_name', $value['model_name']),
                    'icon' => $this->getInfoAboutModel('icon', $value['model_name']),
                    'hide_view_mode' => $this->getInfoAboutModel('hide_view_mode', $value['model_name']),
                    'has_owner_field' => $this->getInfoAboutModel('has_owner_field', $value['model_name']),
                    'ownership_fields' => $this->getInfoAboutModel('ownership_fields', $value['model_name']),
                    'use_card_for_browse' => $this->getInfoAboutModel('use_card_for_browse', $value['model_name']),
                    'add_new_label' => $this->getInfoAboutModel('add_new_label', $value['model_name']),
                    'edit_label' => $this->getInfoAboutModel('edit_label', $value['model_name']),
                    'delete_label' => $this->getInfoAboutModel('delete_label', $value['model_name']),
                    'default_order_by' => $this->getInfoAboutModel('default_order_by', $value['model_name']),
                    'default_order_by_direction' => $this->getInfoAboutModel('default_order_by_direction', $value['model_name']),
                    'is_displayed_on_app_center' => $this->getInfoAboutModel('is_displayed_on_app_center', $value['model_name']),
                    'app_center_group' => $this->getInfoAboutModel('app_center_group', $value['model_name'])
                ]
            );
        }
        foreach ($models as $model){
            $dwPDetailArr = [];
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'B', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'BTO', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'R', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'RTO', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'E', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'ETO', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'A', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'D', 'dw_model_id' => $model->id]);
            $dwPDetailArr[] = \App\DwPermissionDetail::firstOrCreate(['permission_name' => 'DTO', 'dw_model_id' => $model->id]);
            $roleColl = \App\Role::all();
            foreach ($roleColl as $role){
                foreach ($dwPDetailArr as $dwPDetail){
                    $trueOrFalse = true;
                    if(in_array($dwPDetail->permission_name, ['BTO', 'RTO', 'ETO', 'DTO'])  ){
                        $trueOrFalse = false;
                    }
                    \App\DwPermissionDetailRole::firstOrCreate([
                        'role_id' => $role->id,
                        'dw_permission_detail_id' => $dwPDetail->id,
                        'is_allowed' => $trueOrFalse
                    ]);
                }
            }
        }

        Artisan::call('cache:clear');
        Artisan::call('config:clear');
    }

    private function getInfoAboutModel($attr, $modelName){

        $arr = [
            'DwModel' => [
                'is_displayed_on_app_center' => 1,
                'app_center_group' => 'Controle sistema',
                'singular_name' => 'Model',
                'plural_name' => 'Models',
                'gender' => 'F',
                'icon' => 'fas fa-database',
            ],
            'DwPermissionDetail' => [
                'is_displayed_on_app_center' => 0,
                'app_center_group' => 'Controle sistema',
                'singular_name' => 'Detalhe de permissão',
                'plural_name' => 'Detalhes da permissão',
                'gender' => 'F',
                'icon' => 'fas fa-atom',
            ],
            'DwPermissionDetailRole' => [
                'is_displayed_on_app_center' => 0,
                'app_center_group' => 'Controle sistema',
                'singular_name' => 'Detalhe da permissão por perfil',
                'plural_name' => 'Detalhes da permissão por perfil',
                'gender' => 'F',
                'icon' => 'fas fa-atom',
            ],
            'Role' => [
                'is_displayed_on_app_center' => 1,
                'app_center_group' => 'Controle sistema',
                'singular_name' => 'Função',
                'plural_name' => 'Funções',
                'gender' => 'F',
                'icon' => 'fas fa-user-shield',
            ],
            'User' => [
                'is_displayed_on_app_center' => 1,
                'app_center_group' => 'Controle sistema',
                'singular_name' => 'Usuário',
                'plural_name' => 'Usuários',
                'gender' => 'M',
                'icon' => 'fas fa-user',
            ],
            'default' => [
                'is_displayed_on_app_center' => 1,
                'app_center_group' => 'Outros',
                'singular_name' => $modelName,
                'plural_name' => $modelName,
                'gender' => 'F',
                'icon' => 'fas fa-atom',
                'has_owner_field' => false,
                'hide_view_mode' => '',
                'ownership_fields' => 'user_id',
                'use_card_for_browse' => '',
                'add_new_label' => 'adicionar',
                'edit_label' => 'editar',
                'delete_label' => 'excluir',
                'default_order_by' => '',
                'default_order_by_direction' => '',
            ]
        ];
        if(config('daspeweb.slug-info.'.$modelName.'.'.$attr) !== null){
            return config('daspeweb.slug-info.'.$modelName.'.'.$attr);
        }
        if (isset($arr[$modelName][$attr])){
            return $arr[$modelName][$attr];
        }
        return $arr['default'][$attr];
    }
}

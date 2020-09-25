<?php

namespace Daspeweb\Framework;
use App\DwModel;
use App\Observers\DwModelObserver;
use App\Observers\RoleObserver;
use App\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Router;


class DaspeWebFrameworkServiceProvider extends ServiceProvider {

    protected $commands = [
        'Daspeweb\Framework\Console\Commands\MakeModelDaspeweb',
        'Daspeweb\Framework\Console\Commands\SetModelsAndPermissions',
        'Daspeweb\Framework\Console\Commands\SetUpProject',
        'Daspeweb\Framework\Console\Commands\UserControl',
    ];
    public function boot()
    {

        //rotas
        //$this->publishes([__DIR__ . '/routes/routes.php' => base_path('/routes/web.php')], 'daspeweb-rotas');
        //config
        $this->publishes([__DIR__.'/config/daspeweb.php' => config_path('daspeweb.php'),], 'daspeweb');
        //migrations
        $this->publishes([__DIR__.'/database/migrations/' => database_path('migrations')], 'daspeweb');
        //seeds
        $this->publishes([__DIR__.'/database/seeds/' => database_path('seeds')], 'daspeweb');
        //rules
        $this->publishes([__DIR__.'/app/Rules' => app_path('Rules')], 'daspeweb');
        //commands
        //$this->publishes([__DIR__.'/app/Console/Commands' => app_path('/Console/Commands')], 'daspeweb');

        //models
        $this->publishes([__DIR__.'/app/ListView.php' => app_path('/ListView.php')], 'daspeweb-models');
        $this->publishes([__DIR__.'/app/ListViewCriteria.php' => app_path('/ListViewCriteria.php')], 'daspeweb-models');
        $this->publishes([__DIR__.'/app/Role.php' => app_path('/Role.php')], 'daspeweb-models');
        $this->publishes([__DIR__.'/app/User.php' => app_path('/User.php')], 'daspeweb-models');
        $this->publishes([__DIR__.'/app/UserForAdmin.php' => app_path('/UserForAdmin.php')], 'daspeweb-models');
        $this->publishes([__DIR__.'/app/DwModel.php' => app_path('/DwModel.php')], 'daspeweb-models');
        $this->publishes([__DIR__.'/app/DwPermissionDetail.php' => app_path('/DwPermissionDetail.php')], 'daspeweb-models');
        $this->publishes([__DIR__.'/app/DwPermissionDetailRole.php' => app_path('/DwPermissionDetailRole.php')], 'daspeweb-models');

        //assets
        $this->publishes([__DIR__.'/public/daspeweb_assets' => public_path('daspeweb_assets'),], 'daspeweb');
        $this->publishes([__DIR__.'/public/daspeweb_assets/mdb/mdb-addons/mdb-lightbox-ui.html' =>
            public_path('/mdb/mdb-addons/mdb-lightbox-ui.html')], 'daspeweb');

        //arrumar o arquivo html do mdb //pendencia
        //resources
        $this->loadViewsFrom(__DIR__.'/resources/views', 'daspeweb');
        $this->publishes([__DIR__.'/resources/lang/pt_br' => resource_path('lang/pt_br'),], 'daspeweb');
        $this->publishes([__DIR__.'/resources/views/auth' => resource_path('views/auth'),], 'daspeweb');

        $this->publishes([__DIR__.'/resources/views/app_layout/partials/navbar.blade.php' => resource_path('views/app_layout/partials/navbar.blade.php'),], 'daspeweb');
        $this->publishes([__DIR__.'/resources/views/app_layout/partials/sidebar.blade.php' => resource_path('views/app_layout/partials/sidebar.blade.php'),], 'daspeweb');

        $this->loadRoutesFrom(__DIR__.'/routes/web-routes.php');
        $this->loadRoutesFrom(__DIR__.'/routes/api-routes.php');

        //observers
        if(class_exists('\\App\\Role')){
            Role::observe(\Daspeweb\Framework\Observers\RoleObserver::class);
            DwModel::observe(\Daspeweb\Framework\Observers\DwModelObserver::class);
        }
    }
    public function register()
    {
        $this->commands($this->commands);
    }
}


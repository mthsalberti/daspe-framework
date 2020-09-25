<?php

namespace Daspeweb\Framework\Observers;

use App\Role;
use Daspeweb\Framework\Console\Commands\SetModelsAndPermissions;
use Daspeweb\Framework\DaspewebHelper;
use Illuminate\Support\Facades\Artisan;

class RoleObserver
{
    public function saved(Role $role){
        $command = new SetModelsAndPermissions();
        $command->handle();
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
    }
}
